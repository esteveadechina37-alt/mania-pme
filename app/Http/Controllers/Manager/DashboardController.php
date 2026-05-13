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

        // Membres de l'équipe actifs
        $teamMembersCount = User::where('company_id', $company->id)
            ->where('is_active', true)
            ->whereHas('roles', fn($q) => $q->whereIn('name', ['employe', 'stagiaire']))
            ->count();

        // Demandes de congé en attente pour le département du manager
        $department = Department::where('manager_id', $user->id)->first();
        $pendingRequests = 0;
        if ($department) {
            $employeeIds = $department->employees()->pluck('id');
            $pendingRequests = LeaveRequest::whereIn('employee_id', $employeeIds)
                ->where('status', 'pending')
                ->count();
        }

        $presentToday = 0; // module à venir

        return view('manager.dashboard', compact(
            'teamMembersCount',
            'pendingRequests',
            'presentToday'
        ));
    }
}