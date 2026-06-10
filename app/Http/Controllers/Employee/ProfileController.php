<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
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

    private function getAnciennete(Employee $employee): ?array
{
    if (!$employee->hire_date) {
        return null;
    }

    $hireDate = Carbon::parse($employee->hire_date)->startOfDay();
    $now      = now()->startOfDay();

    // Années entières
    $years = $hireDate->diffInYears($now);

    // On retire les années pleines
    $afterYears = $hireDate->copy()->addYears($years);

    // Mois entiers restants (en évitant les débordements de jour)
    $months = 0;
    while ($afterYears->copy()->addMonth()->lte($now)) {
        $afterYears->addMonth();
        $months++;
    }

    // Jours restants après le dernier mois
    $days = $afterYears->diffInDays($now);

    return [
        'years'  => $years,
        'months' => $months,
        'days'   => $days,
    ];
}

    // private function getAnciennete(Employee $employee): ?array
    // {
    //     if (!$employee->hire_date) {
    //         return null;
    //     }

    //     $hireDate = Carbon::parse($employee->hire_date);
    //     $now      = now();

    //     $years  = $hireDate->diffInYears($now);
    //     $months = $hireDate->copy()->addYears($years)->diffInMonths($now);
    //     $days   = $hireDate->copy()->addYears($years)->addMonths($months)->diffInDays($now);

    //     return [
    //         'years'      => $years,
    //         'months'     => $months,
    //         'days'       => $days,
    //         'hire_date'  => $hireDate->format('d/m/Y'),
    //     ];
    // }

    public function index()
    {
        $user       = Auth::user();
        $employee   = $this->getEmployee();
        $anciennete = $this->getAnciennete($employee);

        return view('employee.profile', compact('user', 'employee', 'anciennete'));
    }
}