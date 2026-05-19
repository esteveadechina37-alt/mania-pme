<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Récupère (ou crée) la fiche employé de l'utilisateur connecté.
     * (identique à la méthode utilisée dans LeaveRequestController)
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
        $employee = $this->getEmployee(); // garantit que l'employé existe

        // Congés restants (à dynamiser plus tard)
        $congesRestants = 25;

        // Dernière fiche de paie (simulée)
        $derniereFicheDate = 'Avril 2026';

        // Heures pointées (simulé)
        $heuresPointees = 0;

        // Demandes récentes de l'employé (5 dernières)
        $demandesRecentes = $employee->leaveRequests()
            ->with('leaveType')
            ->latest()
            ->take(5)
            ->get();

        return view('employee.dashboard', compact(
            'congesRestants',
            'derniereFicheDate',
            'heuresPointees',
            'demandesRecentes'
        ));
    }
}