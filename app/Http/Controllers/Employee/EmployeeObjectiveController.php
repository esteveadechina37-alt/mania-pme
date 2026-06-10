<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\WeeklyProgramObjective;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeObjectiveController extends Controller
{
    /**
     * Met à jour le statut et la progression d'un objectif assigné à l'employé connecté.
     */
    public function update(Request $request, WeeklyProgramObjective $objective)
    {
        $user = Auth::user();

        // Récupérer ou créer l'employé lié à l'utilisateur
        $employee = Employee::where('user_id', $user->id)->first();
        if (!$employee) {
            $employee = Employee::create([
                'user_id'    => $user->id,
                'company_id' => $user->company_id,
                'status'     => 'active',
                'hire_date'  => now(),
            ]);
        }

        // Vérifier que l'objectif est bien assigné à cet employé
        if ($objective->employee_id !== $employee->id) {
            abort(403, 'Cette tâche ne vous est pas assignée.');
        }

        // Valider les données
        $request->validate([
            'status'   => 'required|in:pending,in_progress,achieved,not_achieved',
            'progress' => 'nullable|numeric|min:0',
        ]);

        // Mettre à jour l'objectif
        $objective->update([
            'status'   => $request->status,
            'progress' => $request->progress ?? $objective->progress,
        ]);

        return back()->with('success', 'Statut de la tâche mis à jour.');
    }
}