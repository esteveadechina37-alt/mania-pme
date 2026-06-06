<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TeamController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $department = Department::where('manager_id', $user->id)->first();

        if (!$department) {
            return view('manager.team', [
                'department'     => null,
                'employees'      => collect([]),
                'totalMembers'   => 0,
                'onLeaveToday'   => 0,
                'presentToday'   => 0,
                'upcomingLeaves' => collect([]),
                'calendarData'   => collect([]),
                'chartData'      => $this->emptyChartData(),
            ]);
        }

        $employees   = Employee::where('department_id', $department->id)
                            ->where('status', 'active')
                            ->whereNull('deleted_at')
                            ->with('user')
                            ->get();

        $employeeIds = $employees->pluck('id');
        $today       = now()->toDateString();

        $totalMembers = $employees->count();
        $onLeaveToday = LeaveRequest::whereIn('employee_id', $employeeIds)
                            ->where('status', 'approved')
                            ->where('start_date', '<=', $today)
                            ->where('end_date', '>=', $today)
                            ->count();
        $presentToday = Attendance::whereIn('employee_id', $employeeIds)
                            ->where('date', $today)
                            ->count();

        $upcomingLeaves = LeaveRequest::whereIn('employee_id', $employeeIds)
                            ->where('start_date', '>', $today)
                            ->with('employee.user', 'leaveType')
                            ->orderBy('start_date')
                            ->take(10)
                            ->get();

        // Calendrier 14 jours
        $calendarData = collect();
        for ($i = 0; $i < 14; $i++) {
            $date     = now()->addDays($i)->toDateString();
            $dayName  = now()->addDays($i)->isoFormat('ddd D MMM');
            $leaveEmployees = $employees->filter(function ($emp) use ($date) {
                return $emp->leaveRequests()
                    ->where('status', 'approved')
                    ->where('start_date', '<=', $date)
                    ->where('end_date', '>=', $date)
                    ->exists();
            })->map(fn($emp) => $emp->user->name)->values();

            $calendarData->push([
                'date'     => $date,
                'dayLabel' => $dayName,
                'names'    => $leaveEmployees,
            ]);
        }

        // Graphique — 7 derniers jours
        $chartData = $this->buildChartData($employeeIds);

        return view('manager.team', compact(
            'department',
            'employees',
            'totalMembers',
            'onLeaveToday',
            'presentToday',
            'upcomingLeaves',
            'calendarData',
            'chartData'
        ));
    }

    private function buildChartData($employeeIds): array
    {
        $labels           = [];
        $presencesCurrent = [];
        $congesCurrent    = [];
        $heuresCurrent    = [];
        $presencesPrev    = [];
        $congesPrev       = [];
        $heuresPrev       = [];

        for ($i = 6; $i >= 0; $i--) {
            $dateCurrent = now()->subDays($i)->toDateString();
            $datePrev    = now()->subDays($i + 7)->toDateString();

            $labels[] = now()->subDays($i)->isoFormat('ddd');

            // Présences semaine courante
            $presencesCurrent[] = Attendance::whereIn('employee_id', $employeeIds)
                ->where('date', $dateCurrent)->count();

            // Présences semaine précédente
            $presencesPrev[] = Attendance::whereIn('employee_id', $employeeIds)
                ->where('date', $datePrev)->count();

            // Congés semaine courante
            $congesCurrent[] = LeaveRequest::whereIn('employee_id', $employeeIds)
                ->where('status', 'approved')
                ->where('start_date', '<=', $dateCurrent)
                ->where('end_date', '>=', $dateCurrent)
                ->count();

            // Congés semaine précédente
            $congesPrev[] = LeaveRequest::whereIn('employee_id', $employeeIds)
                ->where('status', 'approved')
                ->where('start_date', '<=', $datePrev)
                ->where('end_date', '>=', $datePrev)
                ->count();

            // Heures (présences * 8h par défaut si pas de pointage précis)
            $heuresCurrent[] = $presencesCurrent[count($presencesCurrent) - 1] * 8;
            $heuresPrev[]    = $presencesPrev[count($presencesPrev) - 1] * 8;
        }

        return [
            'labels'    => $labels,
            'presences' => ['current' => $presencesCurrent, 'prev' => $presencesPrev],
            'conges'    => ['current' => $congesCurrent,    'prev' => $congesPrev],
            'heures'    => ['current' => $heuresCurrent,    'prev' => $heuresPrev],
        ];
    }

    private function emptyChartData(): array
    {
        $labels = [];
        for ($i = 6; $i >= 0; $i--) {
            $labels[] = now()->subDays($i)->isoFormat('ddd');
        }
        return [
            'labels'    => $labels,
            'presences' => ['current' => [0,0,0,0,0,0,0], 'prev' => [0,0,0,0,0,0,0]],
            'conges'    => ['current' => [0,0,0,0,0,0,0], 'prev' => [0,0,0,0,0,0,0]],
            'heures'    => ['current' => [0,0,0,0,0,0,0], 'prev' => [0,0,0,0,0,0,0]],
        ];
    }
}