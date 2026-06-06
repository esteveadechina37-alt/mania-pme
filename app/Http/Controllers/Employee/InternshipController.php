<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class InternshipController extends Controller
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

    public function index()
    {
        $user = Auth::user();
        $employee = $this->getEmployee();

        return view('employee.internship', compact('user', 'employee'));
    }
}