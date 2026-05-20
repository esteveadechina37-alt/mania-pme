<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use App\Models\LeaveRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $company = $user->company;

        // Département dont le manager est responsable
        $department = Department::withCount(['employees' => function ($q) {
            $q->where('status', 'active')->whereNull('deleted_at');
        }])->where('manager_id', $user->id)->first();

        // Membres de l'équipe actifs dans l'entreprise
        $teamMembersCount = User::where('company_id', $company->id)
            ->where('is_active', true)
            ->whereHas('roles', fn($q) => $q->whereIn('name', ['employe', 'stagiaire']))
            ->count();

        // Demandes de congé en attente pour le département du manager
        $pendingRequests = 0;
        if ($department) {
            $employeeIds = $department->employees()->pluck('id');
            $pendingRequests = LeaveRequest::whereIn('employee_id', $employeeIds)
                ->where('status', 'pending')
                ->count();
        }

        $presentToday = 0; // sera dynamisé avec le module présences
        $presentToday = 0;
        if ($department) {
            $presentToday = \App\Models\Attendance::whereIn('employee_id', $department->employees()->pluck('id'))
                            ->where('date', now()->toDateString())
                            ->count();
        }
        
        // Employés du département (actifs)
        $teamUsers = $department
            ? $department->employees()
                ->where('status', 'active')
                ->whereNull('deleted_at')
                ->with('user')
                ->take(5)->get()
            : collect();

        return view('manager.dashboard', compact(
            'teamMembersCount',
            'pendingRequests',
            'presentToday',
            'department',
            'teamUsers'
        ));
    }
}