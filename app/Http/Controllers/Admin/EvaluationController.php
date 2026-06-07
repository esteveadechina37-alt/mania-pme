<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Mail\RhNotificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB; 

class EvaluationController extends Controller
{
    public function index()
{
    $user = auth()->user();
    $companyId = $user->company_id;

    // Requête de base pour les évaluations (avec filtres selon le rôle)
    $baseQuery = Evaluation::where('company_id', $companyId)
                    ->with('employee.user', 'evaluator')
                    ->when($user->hasRole('manager'), function ($query) use ($user) {
                        $department = Department::where('manager_id', $user->id)->first();
                        if ($department) {
                            $employeeIds = $department->employees()->pluck('id');
                            $query->whereIn('employee_id', $employeeIds);
                        } else {
                            $query->whereRaw('1 = 0'); // aucune évaluation
                        }
                    });

    // Liste paginée
    $evaluations = (clone $baseQuery)
                    ->orderBy('evaluated_at', 'desc')
                    ->paginate(15);

    // Dernière évaluation (la plus récente selon evaluated_at)
    $recentEvaluation = (clone $baseQuery)
                        ->orderBy('evaluated_at', 'desc')
                        ->first();

    // Employé le mieux évalué (moyenne des scores) dans le même périmètre
    $topEmployee = null;
    $topQuery = DB::table('evaluations')
                ->where('company_id', $companyId)
                ->when($user->hasRole('manager'), function ($query) use ($user) {
                    $department = Department::where('manager_id', $user->id)->first();
                    if ($department) {
                        $employeeIds = $department->employees()->pluck('id');
                        $query->whereIn('employee_id', $employeeIds);
                    } else {
                        $query->whereRaw('1 = 0');
                    }
                })
                ->select('employee_id', DB::raw('AVG(score) as average_score'))
                ->groupBy('employee_id')
                ->orderByDesc('average_score')
                ->first();

    if ($topQuery) {
        $employee = Employee::with('user', 'department')->find($topQuery->employee_id);
        if ($employee && $employee->user) {
            $topEmployee = [
                'name'          => $employee->user->name,
                'average_score' => $topQuery->average_score,
                'department'    => optional($employee->department)->name,
            ];
        }
    }

    return view('admin.evaluations.index', compact('evaluations', 'recentEvaluation', 'topEmployee'));
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

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'employee_id'  => 'required|exists:employees,id',
    //         'period'       => 'required|string|max:255',
    //         'score'        => 'required|numeric|min:0|max:5',
    //         'comments'     => 'nullable|string|max:2000',
    //         'evaluated_at' => 'nullable|date',
    //     ]);

    //     $user = auth()->user();
    //     $employee = Employee::findOrFail($request->employee_id);

    //     // Vérification de sécurité : l'employé doit appartenir à l'entreprise
    //     if ($employee->company_id !== $user->company_id) {
    //         abort(403, 'Cet employé n’appartient pas à votre entreprise.');
    //     }

    //     // Si manager, vérifier que l'employé est dans son département
    //     if ($user->hasRole('manager')) {
    //         $department = Department::where('manager_id', $user->id)->first();
    //         if (!$department || $employee->department_id !== $department->id) {
    //             abort(403, 'Vous ne pouvez évaluer que les employés de votre département.');
    //         }
    //     }

    //     Evaluation::create([
    //         'employee_id'  => $employee->id,
    //         'company_id'   => $user->company_id,
    //         'evaluator_id' => $user->id,
    //         'period'       => $request->period,
    //         'score'        => $request->score,
    //         'comments'     => $request->comments,
    //         'evaluated_at' => $request->evaluated_at ?: now(),
    //     ]);

    //     $employee = $evaluation->employee;
    //     $user = $employee->user;

    //     $title = 'Nouvelle évaluation disponible';
    //     $message = "Une nouvelle évaluation (période : {$evaluation->period}) a été ajoutée à votre dossier.";

    //     \App\Models\Notification::create([
    //         'user_id'    => $user->id,
    //         'company_id' => $user->company_id,
    //         'type'       => 'evaluation_created',
    //         'title'      => $title,
    //         'message'    => $message,
    //     ]);

    //     try {
    //         Mail::to($user->email)->send(new RhNotificationMail($title, $message, $user->name));
    //     } catch (\Exception $e) {
    //         \Log::error("Erreur envoi mail : " . $e->getMessage());
    //     }

    //     return redirect()->route('admin.evaluations.index')->with('success', 'Évaluation enregistrée.');
    // }

    public function store(Request $request)
{
    $request->validate([
        'employee_id'  => 'required|exists:employees,id',
        'period'       => 'required|string|max:255',
        'score'        => 'required|numeric|min:0|max:5',
        'comments'     => 'nullable|string|max:2000',
        'evaluated_at' => 'nullable|date',
    ]);

    $currentUser = auth()->user();
    $employee = Employee::findOrFail($request->employee_id);

    // Vérification de sécurité : l’employé doit appartenir à l’entreprise
    if ($employee->company_id !== $currentUser->company_id) {
        abort(403, 'Cet employé n’appartient pas à votre entreprise.');
    }

    // Si manager, vérifier que l'employé est dans son département
    if ($currentUser->hasRole('manager')) {
        $department = Department::where('manager_id', $currentUser->id)->first();
        if (!$department || $employee->department_id !== $department->id) {
            abort(403, 'Vous ne pouvez évaluer que les employés de votre département.');
        }
    }

    // Création de l'évaluation
    $evaluation = Evaluation::create([
        'employee_id'  => $employee->id,
        'company_id'   => $currentUser->company_id,
        'evaluator_id' => $currentUser->id,
        'period'       => $request->period,
        'score'        => $request->score,
        'comments'     => $request->comments,
        'evaluated_at' => $request->evaluated_at ?: now(),
    ]);

    // Notification à l'employé évalué
    $notifiedUser = $employee->user; // utilisateur lié à l'employé
    $title = 'Nouvelle évaluation disponible';
    $message = "Une nouvelle évaluation (période : {$evaluation->period}) a été ajoutée à votre dossier.";

    \App\Models\Notification::create([
        'user_id'    => $notifiedUser->id,
        'company_id' => $notifiedUser->company_id,
        'type'       => 'evaluation_created',
        'title'      => $title,
        'message'    => $message,
    ]);

    try {
        Mail::to($notifiedUser->email)->send(new RhNotificationMail($title, $message, $notifiedUser->name));
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