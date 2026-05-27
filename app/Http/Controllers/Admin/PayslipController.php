<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Payslip;
use Barryvdh\DomPDF\Facade\Pdf as DomPDF;
use Illuminate\Http\Request;

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

        // Vérifier qu'il n'y a pas déjà un bulletin pour ce mois / employé
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

        // Génération du PDF
        $pdfPath = $this->generatePdf($employee, $baseSalary, $bonuses, $deductions, $netSalary, $request->month, $request->year);

        Payslip::create([
            'employee_id' => $employee->id,
            'company_id'  => auth()->user()->company_id,
            'month'       => $request->month,
            'year'        => $request->year,
            'base_salary' => $baseSalary,
            'bonuses'     => $bonuses,
            'deductions'  => $deductions,
            'net_salary'  => $netSalary,
            'pdf_path'    => $pdfPath,
        ]);

        return redirect()->route('admin.payslips.index')->with('success', 'Bulletin généré.');
    }

    // public function download(Payslip $payslip)
    // {
    //     $filePath = storage_path('app/' . $payslip->pdf_path);
    //     if (!file_exists($filePath)) {
    //         return back()->with('error', 'Le fichier PDF est introuvable.');
    //     }

    //     return response()->download($filePath);
    // }

    public function download(Payslip $payslip)
    {
        if (!\Storage::exists($payslip->pdf_path)) {
            return back()->with('error', 'Le fichier PDF est introuvable.');
        }

        return \Storage::download($payslip->pdf_path);
    }
    
    public function destroy(Payslip $payslip)
    {
        // Supprimer le fichier PDF du serveur
        $filePath = storage_path('app/' . $payslip->pdf_path);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $payslip->delete();
        return redirect()->route('admin.payslips.index')->with('success', 'Bulletin supprimé.');
    }

    /**
     * Génère le PDF du bulletin de paie et retourne le chemin de stockage.
     */
    private function generatePdf(Employee $employee, $baseSalary, $bonuses, $deductions, $netSalary, $month, $year)
    {
        $months = [
            '01' => 'Janvier', '02' => 'Février', '03' => 'Mars', '04' => 'Avril',
            '05' => 'Mai', '06' => 'Juin', '07' => 'Juillet', '08' => 'Août',
            '09' => 'Septembre', '10' => 'Octobre', '11' => 'Novembre', '12' => 'Décembre'
        ];

        $data = [
            'employee'    => $employee->load('user', 'company'),
            'base_salary' => $baseSalary,
            'bonuses'     => $bonuses,
            'deductions'  => $deductions,
            'net_salary'  => $netSalary,
            'month'       => $months[$month] ?? $month,
            'year'        => $year,
        ];

        $pdf = DomPDF::loadView('admin.payslips.pdf', $data);

        $directory = 'payslips/' . $employee->company_id;
        $filename  = $directory . '/bulletin_' . $employee->id . '_' . $year . '_' . $month . '.pdf';

        \Storage::makeDirectory($directory);

        // Enregistrer le PDF dans le stockage
        \Storage::put($filename, $pdf->output());

        return $filename;
    }
}