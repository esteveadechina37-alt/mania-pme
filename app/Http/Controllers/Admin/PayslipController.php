<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Payslip;
use Barryvdh\DomPDF\Facade\Pdf as DomPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Mail\RhNotificationMail;
use Illuminate\Support\Facades\Mail;

class PayslipController extends Controller
{
    public function index()
    {
        $companyId = auth()->user()->company_id;
        $payslips = Payslip::where('company_id', $companyId)
                    ->with('employee.user')
                    ->orderBy('year', 'desc')
                    ->orderBy('month', 'desc')
                    ->paginate(15);

        return view('admin.payslips.index', compact('payslips'));
    }

    public function create()
    {
        $employees = Employee::where('company_id', auth()->user()->company_id)
                    ->where('status', 'active')
                    ->with('user')
                    ->get();

        return view('admin.payslips.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'month'       => 'required|digits:2',
            'year'        => 'required|digits:4',
            'bonuses'     => 'nullable|numeric|min:0',
            'deductions'  => 'nullable|numeric|min:0',
        ]);

        $employee = Employee::findOrFail($request->employee_id);

        $exists = Payslip::where('employee_id', $employee->id)
            ->where('month', $request->month)
            ->where('year', $request->year)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Un bulletin existe déjà pour cet employé sur cette période.');
        }

        $baseSalary = $employee->salary;
        $bonuses = $request->bonuses ?? 0;
        $deductions = $request->deductions ?? 0;
        $netSalary = $baseSalary + $bonuses - $deductions;

        $hash = Str::random(32);
        $pdfPath = $this->generatePdf($employee, $baseSalary, $bonuses, $deductions, $netSalary, $request->month, $request->year, $hash);

        Payslip::create([
            'employee_id'      => $employee->id,
            'company_id'       => auth()->user()->company_id,
            'month'            => $request->month,
            'year'             => $request->year,
            'base_salary'      => $baseSalary,
            'bonuses'          => $bonuses,
            'deductions'       => $deductions,
            'net_salary'       => $netSalary,
            'pdf_path'         => $pdfPath,
            'verification_hash'=> $hash,
        ]);

        $employee = $payslip->employee;
        $user = $employee->user;

        $title = 'Nouveau bulletin de paie disponible';
        $message = "Votre bulletin de paie pour {$payslip->month}/{$payslip->year} est disponible dans votre espace.";

        \App\Models\Notification::create([
            'user_id'    => $user->id,
            'company_id' => $user->company_id,
            'type'       => 'payslip_available',
            'title'      => $title,
            'message'    => $message,
        ]);

        try {
            Mail::to($user->email)->send(new RhNotificationMail($title, $message, $user->name));
        } catch (\Exception $e) {
            \Log::error("Erreur envoi mail : " . $e->getMessage());
        }

        return redirect()->route('admin.payslips.index')->with('success', 'Bulletin généré.');
    }

    public function download(Payslip $payslip)
    {
        if (!\Storage::exists($payslip->pdf_path)) {
            return back()->with('error', 'Le fichier PDF est introuvable.');
        }

        return \Storage::download($payslip->pdf_path);
    }

    public function destroy(Payslip $payslip)
    {
        if (\Storage::exists($payslip->pdf_path)) {
            \Storage::delete($payslip->pdf_path);
        }
        $payslip->delete();
        return redirect()->route('admin.payslips.index')->with('success', 'Bulletin supprimé.');
    }


    private function generatePdf(Employee $employee, $baseSalary, $bonuses, $deductions, $netSalary, $month, $year, $hash)
{
    $months = [
        '01' => 'Janvier', '02' => 'Février', '03' => 'Mars', '04' => 'Avril',
        '05' => 'Mai', '06' => 'Juin', '07' => 'Juillet', '08' => 'Août',
        '09' => 'Septembre', '10' => 'Octobre', '11' => 'Novembre', '12' => 'Décembre'
    ];

    $verificationUrl = route('payslips.verify', ['hash' => $hash]);

    // ✅ Générer en PNG puis encoder en base64
    $qrCodeSvg = QrCode::format('svg')
                   ->size(150)
                   ->margin(2)
                   ->generate($verificationUrl);

    $qrCodeBase64 = base64_encode($qrCodeSvg);
    // $qrCodePng = QrCode::format('png')
    //                    ->size(150)
    //                    ->margin(2)
    //                    ->generate($verificationUrl);

    // $qrCodeBase64 = base64_encode($qrCodePng);

    $data = [
        'employee'    => $employee->load('user', 'company'),
        'base_salary' => $baseSalary,
        'bonuses'     => $bonuses,
        'deductions'  => $deductions,
        'net_salary'  => $netSalary,
        'month'       => $months[$month] ?? $month,
        'year'        => $year,
        'qrCode'      => $qrCodeBase64, // ✅ base64 pur, sans préfixe
    ];

    $pdf = DomPDF::loadView('admin.payslips.pdf', $data);

    // ✅ Activer le support des images distantes/base64
    $pdf->getDomPDF()->set_option('isRemoteEnabled', true);

    $directory = 'payslips/' . $employee->company_id;
    $filename  = $directory . '/bulletin_' . $employee->id . '_' . $year . '_' . $month . '.pdf';

    \Storage::makeDirectory($directory);
    \Storage::put($filename, $pdf->output());

    return $filename;
}

    // private function generatePdf(Employee $employee, $baseSalary, $bonuses, $deductions, $netSalary, $month, $year, $hash)
    // {
    //     $months = [
    //         '01' => 'Janvier', '02' => 'Février', '03' => 'Mars', '04' => 'Avril',
    //         '05' => 'Mai', '06' => 'Juin', '07' => 'Juillet', '08' => 'Août',
    //         '09' => 'Septembre', '10' => 'Octobre', '11' => 'Novembre', '12' => 'Décembre'
    //     ];

    //     $verificationUrl = route('payslips.verify', ['hash' => $hash]);

    //     // Générer le QR code en SVG (compatible DomPDF)
    //     // $qrCodeSvg = QrCode::format('svg')
    //     //                    ->size(120)
    //     //                    ->margin(2)
    //     //                    ->generate($verificationUrl);
    //     // Générer le QR code en PNG, puis l'encoder en base64 pour l'afficher dans le PDF
    //     $qrCodeSvg = QrCode::format('svg')
    //                ->size(150)
    //                ->margin(2)
    //                ->generate($verificationUrl);
    //     $data = [
    //         'employee'    => $employee->load('user', 'company'),
    //         'base_salary' => $baseSalary,
    //         'bonuses'     => $bonuses,
    //         'deductions'  => $deductions,
    //         'net_salary'  => $netSalary,
    //         'month'       => $months[$month] ?? $month,
    //         'year'        => $year,
    //         'qrCode' => $qrCodeSvg,
    //     ];

    //     $pdf = DomPDF::loadView('admin.payslips.pdf', $data);

    //     $directory = 'payslips/' . $employee->company_id;
    //     $filename  = $directory . '/bulletin_' . $employee->id . '_' . $year . '_' . $month . '.pdf';

    //     \Storage::makeDirectory($directory);
    //     \Storage::put($filename, $pdf->output());

    //     return $filename;
    // }
}