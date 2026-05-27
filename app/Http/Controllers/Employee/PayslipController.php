<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Payslip;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PayslipController extends Controller
{
    /**
     * Récupère (ou crée) la fiche employé de l'utilisateur connecté.
     */
    private function getEmployee(): Employee
    {
        $user = Auth::user();
        $employee = Employee::where('user_id', $user->id)
                    ->withTrashed()
                    ->first();

        if ($employee) {
            if ($employee->trashed()) {
                $employee->restore();
            }
            $employee->update([
                'status'    => $employee->status ?: 'active',
                'hire_date' => $employee->hire_date ?: now(),
            ]);
            return $employee;
        }

        return Employee::create([
            'user_id'    => $user->id,
            'company_id' => $user->company_id,
            'status'     => 'active',
            'hire_date'  => now(),
        ]);
    }

    public function index()
    {
        $employee = $this->getEmployee(); // garantit une fiche employé

        $payslips = Payslip::where('employee_id', $employee->id)
                    ->orderBy('year', 'desc')
                    ->orderBy('month', 'desc')
                    ->paginate(12);

        return view('employee.payslips.index', compact('payslips'));
    }

   public function download(Payslip $payslip)
    {
        $employee = $this->getEmployee();

        if ($payslip->employee_id !== $employee->id) {
            abort(403);
        }

        // Utilisation de la façade Storage pour cohérence avec l'admin
        if (!\Storage::exists($payslip->pdf_path)) {
            return back()->with('error', 'Le fichier PDF est introuvable.');
        }

        return \Storage::download($payslip->pdf_path);
    }
}