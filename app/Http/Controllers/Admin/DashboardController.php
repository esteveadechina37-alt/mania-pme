<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\Evaluation;
use App\Models\Notification;

class DashboardController extends Controller
{
    public function index()
    {
          $user = auth()->user();

            // Si l'utilisateur est super-admin sans entreprise, on le redirige vers le dashboard super-admin
            if ($user->hasRole('super-admin') && !$user->company) {
                return redirect()->route('super-admin.dashboard');
            }

        $company = auth()->user()->company;
        $today = now()->toDateString();

        // ----- KPIs -----
        $totalEmployees    = User::where('company_id', $company->id)->where('is_active', true)->count();
        $activeEmployees   = Employee::where('company_id', $company->id)->where('status', 'active')->whereNull('deleted_at')->count();
        $pendingLeaves     = LeaveRequest::where('company_id', $company->id)->where('status', 'pending')->count();
        $todayAttendances  = Attendance::where('company_id', $company->id)->where('date', $today)->count();
        $onLeaveToday      = LeaveRequest::where('company_id', $company->id)
                                ->where('status', 'approved')
                                ->where('start_date', '<=', $today)
                                ->where('end_date', '>=', $today)
                                ->count();
        $lateToday         = Attendance::where('company_id', $company->id)->where('date', $today)->where('status', 'late')->count();

        // Contrats expirants dans les 30 jours
        $expiringContracts = Employee::where('company_id', $company->id)
                                ->whereNotNull('contract_end_date')
                                ->where('contract_end_date', '>=', $today)
                                ->where('contract_end_date', '<=', now()->addDays(30)->toDateString())
                                ->whereNull('deleted_at')
                                ->count();

        // ----- Dernières activités -----
        $recentUsers          = User::where('company_id', $company->id)->where('is_active', true)->latest()->take(5)->get();
        $recentLeaveRequests  = LeaveRequest::where('company_id', $company->id)->with('employee.user', 'leaveType')->latest()->take(5)->get();
        $recentEvaluations    = Evaluation::where('company_id', $company->id)->with('employee.user', 'evaluator')->latest()->take(5)->get();

        // ----- Répartition par département (graphique) -----
        $departmentsStats = Department::where('company_id', $company->id)
                                ->withCount(['employees' => function ($q) {
                                    $q->where('status', 'active')->whereNull('deleted_at');
                                }])
                                ->orderByDesc('employees_count')
                                ->get();

        // ----- Notifications récentes (widget latéral) -----
        $notifications = Notification::where('user_id', auth()->id())
                            ->latest()
                            ->take(5)
                            ->get();

        return view('admin.dashboard', compact(
            'totalEmployees', 'activeEmployees', 'pendingLeaves', 'todayAttendances',
            'onLeaveToday', 'lateToday', 'expiringContracts',
            'recentUsers', 'recentLeaveRequests', 'recentEvaluations',
            'departmentsStats', 'notifications'
        ));
    }
}