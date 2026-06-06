<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Evaluation;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    private function getEmployee(): Employee
    {
        $user = Auth::user();
        $employee = Employee::where('user_id', $user->id)->withTrashed()->first();
        if ($employee) {
            if ($employee->trashed()) { $employee->restore(); }
            $employee->update(['status' => $employee->status ?: 'active', 'hire_date' => $employee->hire_date ?: now()]);
            return $employee;
        }
        return Employee::create([
            'user_id' => $user->id, 'company_id' => $user->company_id,
            'status' => 'active', 'hire_date' => now(),
        ]);
    }

    public function index()
    {
        $employee = $this->getEmployee();
        $evaluations = Evaluation::where('employee_id', $employee->id)
                        ->with('evaluator')
                        ->orderBy('evaluated_at', 'desc')
                        ->paginate(10);

        return view('employee.evaluations.index', compact('evaluations'));
    }

    public function show(Evaluation $evaluation)
    {
        $employee = $this->getEmployee();
        if ($evaluation->employee_id !== $employee->id) {
            abort(403);
        }
        $evaluation->load('evaluator');
        return view('employee.evaluations.show', compact('evaluation'));
    }
}