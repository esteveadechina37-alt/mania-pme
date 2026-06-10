<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\WeeklyProgram;
use App\Models\WeeklyProgramObjective;
use App\Models\Department;
use App\Models\Employee;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class WeeklyProgramController extends Controller
{
    // Afficher le programme de la semaine courante (appelé depuis TeamController)
    public function currentWeek(Department $department)
    {
        $user = Auth::user();
        $weekStart = now()->startOfWeek()->toDateString();

        $program = WeeklyProgram::where('department_id', $department->id)
                    ->where('week_start', $weekStart)
                    ->with('objectives')
                    ->first();

        return $program; // renvoyé à la vue via TeamController
    }

    // Enregistrer un nouveau programme ou mettre à jour
    public function storeOrUpdate(Request $request)
        {
            $user = Auth::user();
            $department = Department::where('manager_id', $user->id)->firstOrFail();
            $weekStart = now()->startOfWeek()->toDateString();

            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'objectives' => 'nullable|array',
                'objectives.*.description' => 'required|string',
                'objectives.*.target' => 'nullable|numeric',
            ]);

            $program = WeeklyProgram::updateOrCreate(
                [
                    'department_id' => $department->id,
                    'week_start' => $weekStart,
                ],
                [
                    'manager_id' => $user->id,
                    'title' => $request->title,
                    'description' => $request->description,
                    'status' => 'active',
                ]
            );

            if ($request->has('objectives')) {
                $program->objectives()->delete();
                foreach ($request->objectives as $obj) {
                    $program->objectives()->create([
                        'description' => $obj['description'],
                        'target' => $obj['target'] ?? null,
                        'status' => 'pending',
                    ]);
                }
            }

            return back()->with('success', 'Programme de la semaine mis à jour.');
        }
    // public function storeOrUpdate(Request $request, Department $department)
    // {
    //     $user = Auth::user();
    //     $weekStart = now()->startOfWeek()->toDateString();

    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'description' => 'nullable|string',
    //         'objectives' => 'nullable|array',
    //         'objectives.*.description' => 'required|string',
    //         'objectives.*.target' => 'nullable|numeric',
    //     ]);

    //     $program = WeeklyProgram::updateOrCreate(
    //         [
    //             'department_id' => $department->id,
    //             'week_start' => $weekStart,
    //         ],
    //         [
    //             'manager_id' => $user->id,
    //             'title' => $request->title,
    //             'description' => $request->description,
    //             'status' => 'active',
    //         ]
    //     );

    //     // Mise à jour des objectifs
    //     if ($request->has('objectives')) {
    //         // Supprimer les anciens objectifs non présents dans la requête (optionnel)
    //         $program->objectives()->delete();
    //         foreach ($request->objectives as $obj) {
    //             $program->objectives()->create([
    //                 'description' => $obj['description'],
    //                 'target' => $obj['target'] ?? null,
    //                 'status' => 'pending',
    //             ]);
    //         }
    //     }

    //     return back()->with('success', 'Programme de la semaine mis à jour.');
    // }

    // Mise à jour du statut d'un objectif (AJAX ou formulaire simple)
    public function updateObjective(Request $request, WeeklyProgramObjective $objective)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,achieved,not_achieved',
            'progress' => 'nullable|numeric|min:0',
        ]);

        $objective->update([
            'status' => $request->status,
            'progress' => $request->progress ?? $objective->progress,
        ]);

        return back()->with('success', 'Objectif mis à jour.');
    }

    public function assignEmployee(Request $request, WeeklyProgramObjective $objective)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
        ]);

        // Vérifier que l'employé appartient bien au département du programme
        $employee = Employee::findOrFail($request->employee_id);
        if ($employee->department_id !== $objective->weeklyProgram->department_id) {
            abort(403, 'Cet employé n’appartient pas à ce département.');
        }

        // Vérifier que l'employé n'est pas en congé sur la semaine
        $weekStart = $objective->weeklyProgram->week_start;
        $weekEnd = Carbon::parse($weekStart)->endOfWeek();
        $onLeave = LeaveRequest::where('employee_id', $employee->id)
                    ->where('status', 'approved')
                    ->where('start_date', '<=', $weekEnd)
                    ->where('end_date', '>=', $weekStart)
                    ->exists();
        if ($onLeave) {
            return back()->with('error', 'Cet employé est en congé pendant cette semaine et ne peut pas être assigné.');
        }

        $objective->update(['employee_id' => $employee->id]);

        return back()->with('success', 'Employé assigné avec succès.');
    }
}