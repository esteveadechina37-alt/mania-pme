<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Document;
use Barryvdh\DomPDF\Facade\Pdf as DomPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Mail\RhNotificationMail;
use Illuminate\Support\Facades\Mail;

class DocumentController extends Controller
{
    public function index(Request $request)
{
    $companyId = auth()->user()->company_id;

    // Requête de base
    $query = Document::where('company_id', $companyId)
                     ->with('employee.user')
                     ->when($request->filled('employee_id'), fn($q) => $q->where('employee_id', $request->employee_id))
                     ->when($request->filled('type'), fn($q) => $q->where('type', $request->type));

    // Pagination
    $documents = $query->latest()->paginate(10)->appends($request->all());

    // KPIs (sur le périmètre filtré)
    $totalDocuments = (clone $query)->count();
    $totalCertificates = (clone $query)->where('type', 'certificate')->count();
    $distinctEmployees = (clone $query)->distinct('employee_id')->count('employee_id');

    // Employés pour le filtre
    $employees = Employee::where('company_id', $companyId)
                         ->where('status', 'active')
                         ->with('user')
                         ->get();

    return view('admin.documents.index', compact(
        'documents',
        'employees',
        'totalDocuments',
        'totalCertificates',
        'distinctEmployees'
    ));
}
    // public function index()
    // {
    //     $companyId = auth()->user()->company_id;
    //     $documents = Document::where('company_id', $companyId)
    //                   ->with('employee.user')
    //                   ->orderBy('created_at', 'desc')
    //                   ->paginate(15);

    //     return view('admin.documents.index', compact('documents'));
    // }

    public function create()
    {
        $employees = Employee::where('company_id', auth()->user()->company_id)
                    ->where('status', 'active')
                    ->with('user')
                    ->get();

        return view('admin.documents.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'type'        => 'required|in:contract,certificate,other',
            'title'       => 'required|string|max:255',
            'file'        => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        $file = $request->file('file');
        $directory = 'documents/' . auth()->user()->company_id;
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs($directory, $filename);

        Document::create([
            'employee_id' => $request->employee_id,
            'company_id'  => auth()->user()->company_id,
            'type'        => $request->type,
            'title'       => $request->title,
            'file_path'   => $path,
        ]);

        return redirect()->route('admin.documents.index')->with('success', 'Document téléversé.');
    }

    public function destroy(Document $document)
    {
        if (\Storage::exists($document->file_path)) {
            \Storage::delete($document->file_path);
        }
        $document->delete();
        return redirect()->route('admin.documents.index')->with('success', 'Document supprimé.');
    }

    // Formulaire de génération d'attestation
    public function createAttestation()
    {
        $employees = Employee::where('company_id', auth()->user()->company_id)
                    ->where('status', 'active')
                    ->with('user')
                    ->get();

        return view('admin.documents.attestation', compact('employees'));
    }

    // Générer et stocker l'attestation
    public function storeAttestation(Request $request)
    {
        $request->validate([
            'employee_id'    => 'required|exists:employees,id',
            'type'           => 'required|in:work,internship',
            'date_delivrance'=> 'nullable|date',
        ]);

        $employee = Employee::with('user', 'company')->findOrFail($request->employee_id);

        $hash = Str::random(32);
        $pdfPath = $this->generateAttestationPdf($employee, $request->type, $request->date_delivrance, $hash);

        Document::create([
            'employee_id'      => $employee->id,
            'company_id'       => $employee->company_id,
            'type'             => 'certificate',
            'title'            => $request->type == 'work' ? 'Attestation de travail' : 'Attestation de stage',
            'file_path'        => $pdfPath,
            'verification_hash'=> $hash,
        ]);

        $employee = Employee::findOrFail($request->employee_id);
        $user = $employee->user;

        $title = 'Nouvelle attestation disponible';
        $message = "Une attestation (" . ($request->type == 'work' ? 'de travail' : 'de stage') . ") a été générée et est disponible dans votre espace documents.";

        \App\Models\Notification::create([
            'user_id'    => $user->id,
            'company_id' => $user->company_id,
            'type'       => 'attestation_generated',
            'title'      => $title,
            'message'    => $message,
        ]);

        try {
            Mail::to($user->email)->send(new RhNotificationMail($title, $message, $user->name));
        } catch (\Exception $e) {
            \Log::error("Erreur envoi mail attestation : " . $e->getMessage());
        }

        return redirect()->route('admin.documents.index')->with('success', 'Attestation générée.');
    }


   private function generateAttestationPdf(Employee $employee, $type, $date, $hash)
{
    $verificationUrl = route('documents.verify', ['hash' => $hash]);

    $qrCodeSvg = QrCode::format('svg')
                    ->size(120)
                    ->margin(2)
                    ->generate($verificationUrl);

    $qrCodeBase64 = base64_encode($qrCodeSvg);

    // Formater la date en français (ex: "8 juin 2026")
    $formattedDate = \Carbon\Carbon::parse($date)->translatedFormat('j F Y');

    $data = [
        'employee' => $employee->load('user', 'company', 'department'), // department pour le détail
        'type'     => $type,
        'date'     => $formattedDate,
        'qrCode'   => $qrCodeBase64,
    ];

    $pdf = DomPDF::loadView('admin.documents.attestation-pdf', $data);

    $directory = 'documents/' . $employee->company_id;
    $filename  = $directory . '/' . Str::slug($type == 'work' ? 'Attestation de travail' : 'Attestation de stage') 
                . '_' . $employee->user->name . '_' . time() . '.pdf';

    \Storage::makeDirectory($directory);
    \Storage::put($filename, $pdf->output());

    return $filename;
}
    
    // public function storeAttestation(Request $request)
    // {
    //     $request->validate([
    //         'employee_id' => 'required|exists:employees,id',
    //         'type'        => 'required|in:work,internship', // travail ou stage
    //         'date_delivrance' => 'nullable|date',
    //     ]);

    //     $employee = Employee::with('user', 'company')->findOrFail($request->employee_id);

    //     $data = [
    //         'employee' => $employee,
    //         'type'     => $request->type, // 'work' ou 'internship'
    //         'date'     => $request->date_delivrance ?: now()->format('d/m/Y'),
    //     ];

    //     $pdf = DomPDF::loadView('admin.documents.attestation-pdf', $data);

    //     $directory = 'documents/' . $employee->company_id;
    //     $title = $request->type == 'work' ? 'Attestation de travail' : 'Attestation de stage';
    //     $filename = $directory . '/' . Str::slug($title) . '_' . $employee->user->name . '_' . time() . '.pdf';

    //     \Storage::makeDirectory($directory);
    //     \Storage::put($filename, $pdf->output());

    //     Document::create([
    //         'employee_id' => $employee->id,
    //         'company_id'  => $employee->company_id,
    //         'type'        => 'certificate',
    //         'title'       => $title,
    //         'file_path'   => $filename,
    //     ]);

    //     return redirect()->route('admin.documents.index')->with('success', 'Attestation générée.');
    // }

    public function download(Document $document)
    {
        if (!\Storage::exists($document->file_path)) {
            return back()->with('error', 'Fichier introuvable.');
        }
        return \Storage::download($document->file_path);
    }
}