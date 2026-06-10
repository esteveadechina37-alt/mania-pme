<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\Attendance;
use App\Models\Evaluation;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\WeeklyProgram;

class TeamController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $department = Department::where('manager_id', $user->id)->first();

        if (!$department) {
            return view('manager.team', $this->emptyData());
        }

        $employees = Employee::where('department_id', $department->id)
            ->where('status', 'active')
            ->whereNull('deleted_at')
            ->with('user')
            ->get();

        $employeeIds = $employees->pluck('id');
        $today = now()->toDateString();

        $weekStart = now()->startOfWeek()->toDateString();
$currentWeekProgram = WeeklyProgram::where('department_id', $department->id)
                        ->where('week_start', $weekStart)
                        ->with('objectives')
                        ->first();

        // --- KPIs de base ---
        $totalMembers = $employees->count();
        $onLeaveToday = LeaveRequest::whereIn('employee_id', $employeeIds)
            ->where('status', 'approved')
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->count();

        // Présences du jour avec distinction présent/retard
        $attendancesToday = Attendance::whereIn('employee_id', $employeeIds)
            ->where('date', $today)
            ->get()
            ->keyBy('employee_id');

        $presentToday = $attendancesToday->whereIn('status', ['present', 'late'])->count();
        $lateToday = $attendancesToday->where('status', 'late')->count();

        // Retards sur 7 jours glissants
        $lateThisWeek = Attendance::whereIn('employee_id', $employeeIds)
            ->whereBetween('date', [now()->subDays(6)->toDateString(), $today])
            ->where('status', 'late')
            ->count();

        // Taux de présence global (sur 7 jours)
        $totalPossible = $totalMembers * 7; // maximum de pointages sur 7 jours
        $totalPresent7d = Attendance::whereIn('employee_id', $employeeIds)
            ->whereBetween('date', [now()->subDays(6)->toDateString(), $today])
            ->whereIn('status', ['present', 'late'])
            ->count();
        $attendanceRate = $totalPossible > 0 ? round(($totalPresent7d / $totalPossible) * 100) : 0;

        // --- Membres avec statut de présence du jour ---
        $members = $employees->map(function ($emp) use ($attendancesToday, $today) {
        $att = $attendancesToday->get($emp->id);
        // Vérifier si l'employé est en congé approuvé aujourd'hui
        $onLeave = $emp->leaveRequests()
            ->where('status', 'approved')
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->exists();
        
        if ($onLeave) {
            $emp->presence_status = 'on_leave';
        } else {
            $emp->presence_status = $att ? $att->status : 'absent';
        }
        $emp->check_in = $att ? $att->check_in : null;
        return $emp;
    });
        // $members = $employees->map(function ($emp) use ($attendancesToday, $today) {
        //     $att = $attendancesToday->get($emp->id);
        //     $status = 'absent';
        //     if ($att) {
        //         $status = $att->status; // 'present' ou 'late'
        //     }
        //     $emp->presence_status = $status;
        //     $emp->check_in = $att ? $att->check_in : null;
        //     return $emp;
        // });

        // --- Congés à venir ---
        $upcomingLeaves = LeaveRequest::whereIn('employee_id', $employeeIds)
        ->where('status', 'approved')
        ->where(function ($q) use ($today) {
            $q->where('start_date', '>', $today)           // futurs
            ->orWhere(function ($q2) use ($today) {      // en cours
                $q2->where('start_date', '<=', $today)
                    ->where('end_date', '>=', $today);
            });
        })
        ->with('employee.user', 'leaveType')
        ->orderBy('start_date')
        ->take(10)
        ->get();

        // $upcomingLeaves = LeaveRequest::whereIn('employee_id', $employeeIds)
        //     ->where('start_date', '>', $today)
        //     ->with('employee.user', 'leaveType')
        //     ->orderBy('start_date')
        //     ->take(10)
        //     ->get();

        // --- Calendrier 14 jours avec types d'absence ---
        $calendarData = collect();
        for ($i = 0; $i < 14; $i++) {
            $date = now()->addDays($i)->toDateString();
            $dayName = now()->addDays($i)->isoFormat('ddd D MMM');

            $leavesOnDate = LeaveRequest::whereIn('employee_id', $employeeIds)
                ->where('status', 'approved')
                ->where('start_date', '<=', $date)
                ->where('end_date', '>=', $date)
                ->with('employee.user', 'leaveType')
                ->get();

            $calendarData->push([
                'date'     => $date,
                'dayLabel' => $dayName,
                'absences' => $leavesOnDate->map(function ($leave) {
                    return [
                        'name' => $leave->employee->user->name,
                        'type' => $leave->leaveType->name,
                    ];
                }),
            ]);
        }

        // --- Graphique : taux de présence (%) sur 7 jours ---
        $chartData = $this->buildAttendanceRateChart($employeeIds, $totalMembers);

        // --- Performance : moyenne des évaluations ---
        $avgScore = Evaluation::whereIn('employee_id', $employeeIds)
            ->whereNotNull('score')
            ->avg('score') ?? 0;

        return view('manager.team', compact(
            'department',
            'members',
            'totalMembers',
            'onLeaveToday',
            'presentToday',
            'lateToday',
            'lateThisWeek',
            'attendanceRate',
            'upcomingLeaves',
            'calendarData',
            'chartData',
            'avgScore',
            'currentWeekProgram'
        ));
    }

    private function buildAttendanceRateChart($employeeIds, $totalMembers): array
    {
        $labels = [];
        $currentRates = [];
        $prevRates = [];

        for ($i = 6; $i >= 0; $i--) {
            $dateCurrent = now()->subDays($i)->toDateString();
            $datePrev = now()->subDays($i + 7)->toDateString();

            $labels[] = now()->subDays($i)->isoFormat('ddd');

            $presentCurrent = Attendance::whereIn('employee_id', $employeeIds)
                ->where('date', $dateCurrent)
                ->whereIn('status', ['present', 'late'])
                ->count();
            $presentPrev = Attendance::whereIn('employee_id', $employeeIds)
                ->where('date', $datePrev)
                ->whereIn('status', ['present', 'late'])
                ->count();

            $currentRates[] = $totalMembers > 0 ? round(($presentCurrent / $totalMembers) * 100) : 0;
            $prevRates[] = $totalMembers > 0 ? round(($presentPrev / $totalMembers) * 100) : 0;
        }

        return [
            'labels' => $labels,
            'current' => $currentRates,
            'prev' => $prevRates,
        ];
    }

    private function emptyData(): array
    {
        return [
            'department'     => null,
            'members'        => collect([]),
            'totalMembers'   => 0,
            'onLeaveToday'   => 0,
            'presentToday'   => 0,
            'lateToday'      => 0,
            'lateThisWeek'   => 0,
            'attendanceRate' => 0,
            'upcomingLeaves' => collect([]),
            'calendarData'   => collect([]),
            'chartData'      => [
                'labels' => [],
                'current' => [],
                'prev' => []
            ],
            'avgScore' => 0,
        ];
    }
}