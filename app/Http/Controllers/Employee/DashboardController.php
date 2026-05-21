<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
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
        $employee = $this->getEmployee();
        $today = now()->toDateString();

        // --- Congé en cours ---
        $currentLeave = $employee->leaveRequests()
            ->where('status', 'approved')
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->with('leaveType')
            ->first();

        $joursRestants = 0;
        if ($currentLeave) {
            $joursRestants = now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($currentLeave->end_date)->startOfDay(), false) + 1;
        }

        // --- Heures pointées cette semaine (inchangé) ---
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();
        $attendances = Attendance::where('employee_id', $employee->id)
            ->whereBetween('date', [$startOfWeek->toDateString(), $endOfWeek->toDateString()])
            ->whereNotNull('check_out')
            ->get();
        $totalHours = 0;
        foreach ($attendances as $att) {
            $checkIn = \Carbon\Carbon::parse($att->check_in);
            $checkOut = \Carbon\Carbon::parse($att->check_out);
            if ($checkOut->greaterThan($checkIn)) {
                $diffMinutes = $checkIn->diffInMinutes($checkOut);
                $totalHours += round($diffMinutes / 60, 2);
            }
        }
        $heuresPointees = $totalHours;

        // Dernière fiche de paie (simulée)
        $derniereFicheDate = 'Avril 2026';

        // Demandes récentes
        $demandesRecentes = $employee->leaveRequests()
            ->with('leaveType')
            ->latest()
            ->take(5)
            ->get();

        // --- Notifications de retour (si un congé s'est terminé hier) ---
        $yesterday = now()->subDay()->toDateString();
        $endedLeave = $employee->leaveRequests()
            ->where('status', 'approved')
            ->where('end_date', $yesterday)
            ->first();

        if ($endedLeave) {
            $alreadyNotified = \App\Models\Notification::where('user_id', $employee->user_id)
                ->where('company_id', $employee->company_id)
                ->where('type', 'return_from_leave')
                ->where('created_at', '>=', now()->subHours(24))
                ->exists();

            if (!$alreadyNotified) {
                // Notification pour l'employé
                \App\Models\Notification::create([
                    'user_id'    => $employee->user_id,
                    'company_id' => $employee->company_id,
                    'type'       => 'return_from_leave',
                    'title'      => 'Retour de congé',
                    'message'    => 'Votre congé est terminé. Vous êtes de retour aujourd\'hui.',
                ]);

                // Notification au manager du département
                if ($employee->department && $employee->department->manager_id) {
                    \App\Models\Notification::create([
                        'user_id'    => $employee->department->manager_id,
                        'company_id' => $employee->company_id,
                        'type'       => 'return_from_leave',
                        'title'      => 'Retour de congé de ' . $employee->user->name,
                        'message'    => $employee->user->name . ' est de retour aujourd\'hui.',
                    ]);
                }

                // Notification aux admins de l'entreprise
                $admins = \App\Models\User::where('company_id', $employee->company_id)
                    ->whereHas('roles', fn($q) => $q->where('name', 'admin'))
                    ->get();
                foreach ($admins as $admin) {
                    \App\Models\Notification::create([
                        'user_id'    => $admin->id,
                        'company_id' => $employee->company_id,
                        'type'       => 'return_from_leave',
                        'title'      => 'Retour de congé de ' . $employee->user->name,
                        'message'    => $employee->user->name . ' est de retour aujourd\'hui.',
                    ]);
                }
            }
        }

        return view('employee.dashboard', compact(
            'currentLeave',
            'joursRestants',
            'derniereFicheDate',
            'heuresPointees',
            'demandesRecentes'
        ));
    }

    // public function index()
    // {
    //     $employee = $this->getEmployee();
    //     $year = now()->year;

    //    // --- Congés restants (type utilisé dans la dernière demande approuvée) ---
    //     $latestApproved = LeaveRequest::where('employee_id', $employee->id)
    //         ->where('status', 'approved')
    //         ->with('leaveType')
    //         ->latest()
    //         ->first();

    //     if ($latestApproved) {
    //         $leaveType = $latestApproved->leaveType;
    //         $totalDaysAllowed = $leaveType->days_allowed;

    //         // Jours consommés pour ce type sur l'année en cours
    //         $usedDays = LeaveRequest::where('employee_id', $employee->id)
    //             ->where('status', 'approved')
    //             ->where('leave_type_id', $leaveType->id)
    //             ->whereYear('start_date', now()->year)
    //             ->get()
    //             ->sum(function ($lr) {
    //                 return $lr->start_date->diffInDays($lr->end_date) + 1;
    //             });

    //         $congesRestants = max(0, $totalDaysAllowed - $usedDays);
    //     } else {
    //         // Aucune demande approuvée : on affiche le premier type trouvé (ou 0)
    //         $firstType = LeaveType::where('company_id', $employee->company_id)->first();
    //         $congesRestants = $firstType ? $firstType->days_allowed : 0;
    //     }

    //     // // --- Congés restants (basé sur les types de congé et les demandes approuvées) ---
    //     // // Total des jours autorisés (tous types confondus)
    //     // $totalDaysAllowed = LeaveType::where('company_id', $employee->company_id)->sum('days_allowed');

    //     // // Jours déjà consommés (demandes approuvées sur l'année en cours)
    //     // $usedDays = LeaveRequest::where('employee_id', $employee->id)
    //     //     ->where('status', 'approved')
    //     //     ->whereYear('start_date', $year)
    //     //     ->get()
    //     //     ->sum(function ($lr) {
    //     //         return $lr->start_date->diffInDays($lr->end_date) + 1;
    //     //     });

    //     // $congesRestants = max(0, $totalDaysAllowed - $usedDays);

    //     // --- Heures pointées cette semaine ---
    //     $startOfWeek = now()->startOfWeek(); // lundi
    //     $endOfWeek = now()->endOfWeek();     // dimanche

    //     $attendances = Attendance::where('employee_id', $employee->id)
    //         ->whereBetween('date', [$startOfWeek->toDateString(), $endOfWeek->toDateString()])
    //         ->whereNotNull('check_out') // on ne compte que les journées complètes
    //         ->get();

    //     $totalHours = 0;
    //     foreach ($attendances as $att) {
    //         $checkIn = \Carbon\Carbon::parse($att->check_in);
    //         $checkOut = \Carbon\Carbon::parse($att->check_out);

    //         // On ne compte que si le départ est bien après l'arrivée
    //         if ($checkOut->greaterThan($checkIn)) {
    //             $diffMinutes = $checkIn->diffInMinutes($checkOut); // toujours positif
    //             $totalHours += round($diffMinutes / 60, 2);
    //         }
    //     }
    //     // foreach ($attendances as $att) {
    //     //     $checkIn = \Carbon\Carbon::parse($att->check_in);
    //     //     $checkOut = \Carbon\Carbon::parse($att->check_out);
    //     //     $diffMinutes = $checkOut->diffInMinutes($checkIn);
    //     //     $totalHours += round($diffMinutes / 60, 2);
    //     // }

    //     $heuresPointees = $totalHours;

    //     // Dernière fiche de paie (simulée, sera dynamisée plus tard)
    //     $derniereFicheDate = 'Avril 2026';

    //     // Demandes récentes de l'employé (5 dernières)
    //     $demandesRecentes = $employee->leaveRequests()
    //         ->with('leaveType')
    //         ->latest()
    //         ->take(5)
    //         ->get();

    //     return view('employee.dashboard', compact(
    //         'congesRestants',
    //         'derniereFicheDate',
    //         'heuresPointees',
    //         'demandesRecentes'
    //     ));
    // }
}