<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Mail\RhNotificationMail;
use Illuminate\Support\Facades\Mail;

class EvaluationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $companyId = $user->company_id;

        $evaluations = Evaluation::where('company_id', $companyId)
                        ->with('employee.user', 'evaluator')
                        ->when($user->hasRole('manager'), function ($query) use ($user) {
                            $department = Department::where('manager_id', $user->id)->first();
                            if ($department) {
                                $employeeIds = $department->employees()->pluck('id');
                                $query->whereIn('employee_id', $employeeIds);
                            } else {
                                $query->whereRaw('1 = 0'); // aucun département → aucune évaluation
                            }
                        })
                        ->orderBy('evaluated_at', 'desc')
                        ->paginate(15);

        return view('admin.evaluations.index', compact('evaluations'));
    }

    public function create()
    {
        $user = auth()->user();
        $companyId = $user->company_id;

        if ($user->hasRole('admin')) {
            $employees = Employee::where('company_id', $companyId)
                        ->where('status', 'active')
                        ->with('user')
                        ->get();
        } else { // manager
            $department = Department::where('manager_id', $user->id)->first();
            if ($department) {
                $employees = $department->employees()
                                ->where('status', 'active')
                                ->with('user')
                                ->get();
            } else {
                $employees = collect([]);
            }
        }

        return view('admin.evaluations.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id'  => 'required|exists:employees,id',
            'period'       => 'required|string|max:255',
            'score'        => 'required|numeric|min:0|max:5',
            'comments'     => 'nullable|string|max:2000',
            'evaluated_at' => 'nullable|date',
        ]);

        $user = auth()->user();
        $employee = Employee::findOrFail($request->employee_id);

        // Vérification de sécurité : l'employé doit appartenir à l'entreprise
        if ($employee->company_id !== $user->company_id) {
            abort(403, 'Cet employé n’appartient pas à votre entreprise.');
        }

        // Si manager, vérifier que l'employé est dans son département
        if ($user->hasRole('manager')) {
            $department = Department::where('manager_id', $user->id)->first();
            if (!$department || $employee->department_id !== $department->id) {
                abort(403, 'Vous ne pouvez évaluer que les employés de votre département.');
            }
        }

        Evaluation::create([
            'employee_id'  => $employee->id,
            'company_id'   => $user->company_id,
            'evaluator_id' => $user->id,
            'period'       => $request->period,
            'score'        => $request->score,
            'comments'     => $request->comments,
            'evaluated_at' => $request->evaluated_at ?: now(),
        ]);

        $employee = $evaluation->employee;
        $user = $employee->user;

        $title = 'Nouvelle évaluation disponible';
        $message = "Une nouvelle évaluation (période : {$evaluation->period}) a été ajoutée à votre dossier.";

        \App\Models\Notification::create([
            'user_id'    => $user->id,
            'company_id' => $user->company_id,
            'type'       => 'evaluation_created',
            'title'      => $title,
            'message'    => $message,
        ]);

        try {
            Mail::to($user->email)->send(new RhNotificationMail($title, $message, $user->name));
        } catch (\Exception $e) {
            \Log::error("Erreur envoi mail : " . $e->getMessage());
        }

        return redirect()->route('admin.evaluations.index')->with('success', 'Évaluation enregistrée.');
    }

    public function show(Evaluation $evaluation)
    {
        $this->authorizeAccess($evaluation);
        $evaluation->load('employee.user', 'evaluator');
        return view('admin.evaluations.show', compact('evaluation'));
    }

    public function destroy(Evaluation $evaluation)
    {
        $this->authorizeAccess($evaluation);
        $evaluation->delete();
        return redirect()->route('admin.evaluations.index')->with('success', 'Évaluation supprimée.');
    }

    /**
     * Vérifie que l'utilisateur a accès à cette évaluation.
     */
    private function authorizeAccess(Evaluation $evaluation)
    {
        $user = auth()->user();
        if ($evaluation->company_id !== $user->company_id) {
            abort(403);
        }
        if ($user->hasRole('manager')) {
            $department = Department::where('manager_id', $user->id)->first();
            if (!$department || $evaluation->employee->department_id !== $department->id) {
                abort(403);
            }
        }
        // Les admins passent automatiquement
    }
}