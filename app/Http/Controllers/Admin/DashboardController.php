<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // public function index()
    // {
    //     $company = auth()->user()->company;

    //     // Données dynamiques basées sur les tables existantes
    //     $totalEmployees = User::where('company_id', $company->id)->count(); // tous les utilisateurs (pour l'instant tous rôles confondus)

    //     // Congés en attente : pour l'instant pas de table leave_requests → on met 0
    //     $pendingLeaves = 0; // À remplacer par LeaveRequest::where('company_id', ...)->where('status','pending')->count() après migration

    //     // Présences aujourd'hui : pas de table → 0
    //     $todayAttendances = 0;

    //     // Derniers utilisateurs créés (pour aperçu équipe)
    //     $recentUsers = User::where('company_id', $company->id)
    //                        ->latest()
    //                        ->take(5)
    //                        ->get();

    //     return view('admin.dashboard', compact(
    //         'totalEmployees',
    //         'pendingLeaves',
    //         'todayAttendances',
    //         'recentUsers'
    //     ));
    // }
//     public function index()
// {
//     $company = auth()->user()->company;

//     // Total des utilisateurs actifs de l'entreprise (tous rôles confondus)
//     $totalEmployees = User::where('company_id', $company->id)
//                           ->where('is_active', true)
//                           ->count();

//     // Congés en attente : 0 en attendant le module
//     // $pendingLeaves = 0;
//     $pendingLeaves = \App\Models\LeaveRequest::where('company_id', $company->id)
//                       ->where('status', 'pending')
//                       ->count();

//     // Présences aujourd'hui : 0 en attendant le module
//     $todayAttendances = 0;

//     // Derniers utilisateurs actifs
//     $recentUsers = User::where('company_id', $company->id)
//                        ->where('is_active', true)
//                        ->latest()
//                        ->take(5)
//                        ->get();

//     return view('admin.dashboard', compact(
//         'totalEmployees',
//         'pendingLeaves',
//         'todayAttendances',
//         'recentUsers'
//     ));
// }

    public function index()
    {
        $company = auth()->user()->company;

        $totalEmployees = User::where('company_id', $company->id)
                            ->where('is_active', true)
                            ->count();

        $pendingLeaves = LeaveRequest::where('company_id', $company->id)
                            ->where('status', 'pending')
                            ->count();

        $todayAttendances = 0; // sera implémenté avec le module présences

        $recentUsers = User::where('company_id', $company->id)
                        ->where('is_active', true)
                        ->latest()
                        ->take(5)
                        ->get();

        // Nouveau : répartition des employés actifs par département
        $departmentsStats = \App\Models\Department::where('company_id', $company->id)
                                ->withCount(['employees' => function ($q) {
                                    $q->where('status', 'active')->whereNull('deleted_at');
                                }])
                                ->orderByDesc('employees_count')
                                ->get();

        return view('admin.dashboard', compact(
            'totalEmployees',
            'pendingLeaves',
            'todayAttendances',
            'recentUsers',
            'departmentsStats'   // ← nouvelle variable
        ));
    }
}