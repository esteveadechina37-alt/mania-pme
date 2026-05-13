<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveRequestController extends Controller
{
    /**
     * Récupère l'employé lié à l'utilisateur connecté.
     * - Recherche y compris les enregistrements soft-deleted.
     * - Restaure et met à jour si nécessaire.
     * - Crée une nouvelle fiche employé uniquement si aucune n'existe.
     */
    private function getEmployee(): Employee
    {
        $user = Auth::user();

        // Chercher un employé existant (même soft-deleted)
        $employee = Employee::where('user_id', $user->id)
                    ->withTrashed()
                    ->first();

        if ($employee) {
            // Si l'employé était soft-deleted, le restaurer
            if ($employee->trashed()) {
                $employee->restore();
            }

            // S'assurer que les champs essentiels sont remplis
            $employee->update([
                'status'    => $employee->status ?: 'active',
                'hire_date' => $employee->hire_date ?: now(),
            ]);

            return $employee;
        }

        // Aucun employé trouvé → création
        return Employee::create([
            'user_id'    => $user->id,
            'company_id' => $user->company_id,
            'status'     => 'active',
            'hire_date'  => now(),
        ]);
    }

    // Liste des demandes de l'utilisateur connecté (employé/stagiaire)
    public function index()
    {
        $employee = $this->getEmployee();
        $requests = LeaveRequest::where('employee_id', $employee->id)
                    ->with('leaveType', 'approver')
                    ->latest()
                    ->paginate(10);
        return view('leave-requests.index', compact('requests'));
    }

    // Formulaire de création
    public function create()
    {
        $employee = $this->getEmployee();
        $types = LeaveType::where('company_id', $employee->company_id)->get();
        return view('leave-requests.create', compact('types'));
    }

    // Soumettre une demande
    public function store(Request $request)
    {
        $employee = $this->getEmployee();
        $request->validate([
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date'    => 'required|date|after_or_equal:today',
            'end_date'      => 'required|date|after_or_equal:start_date',
            'reason'        => 'nullable|string',
        ]);

        LeaveRequest::create([
            'employee_id'   => $employee->id,
            'company_id'    => $employee->company_id,
            'leave_type_id' => $request->leave_type_id,
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,
            'reason'        => $request->reason,
            'status'        => 'pending',
        ]);

        return redirect()->route('leave-requests.index')->with('success', 'Demande soumise.');
    }

    // Voir une demande (détail)
    public function show(LeaveRequest $leaveRequest)
    {
        $this->authorizeAccess($leaveRequest);
        return view('leave-requests.show', compact('leaveRequest'));
    }

    // Pour manager/admin : liste des demandes à valider
    public function pending()
    {
        $user = Auth::user();
        $companyId = $user->company_id;

        if ($user->hasRole('admin')) {
            $requests = LeaveRequest::where('company_id', $companyId)
                        ->where('status', 'pending')
                        ->with('employee.user', 'leaveType')
                        ->paginate(10);
        } elseif ($user->hasRole('manager')) {
            // Récupérer le département du manager
            $department = \App\Models\Department::where('manager_id', $user->id)->first();
            if ($department) {
                $employeeIds = $department->employees()->pluck('id');
                $requests = LeaveRequest::whereIn('employee_id', $employeeIds)
                            ->where('status', 'pending')
                            ->with('employee.user', 'leaveType')
                            ->paginate(10);
            } else {
                $requests = collect([]);
            }
        } else {
            abort(403);
        }

        return view('leave-requests.pending', compact('requests'));
    }

    // Valider ou refuser
    public function decide(Request $request, LeaveRequest $leaveRequest)
    {
        $this->authorizeApproval($leaveRequest);
        $request->validate([
            'decision' => 'required|in:approved,rejected',
        ]);

        $leaveRequest->update([
            'status'      => $request->decision,
            'approved_by' => Auth::id(),
        ]);

        return redirect()->route('leave-requests.pending')->with('success', 'Décision enregistrée.');
    }

    // Vérifier que l'utilisateur a le droit de voir la demande
    private function authorizeAccess(LeaveRequest $leaveRequest)
    {
        $user = Auth::user();
    if ($user->hasRole('admin') && $leaveRequest->company_id === $user->company_id) return;

    // Pour les employés/stagiaires, on récupère (ou crée) la fiche employé
    if ($user->hasAnyRole(['employe', 'stagiaire'])) {
        $employee = $this->getEmployee();
        if ($employee->id === $leaveRequest->employee_id) return;
    }

    if ($user->hasRole('manager')) {
        $dept = \App\Models\Department::where('manager_id', $user->id)->first();
        if ($dept && $leaveRequest->employee->department_id === $dept->id) return;
    }

    abort(403);
        // $user = Auth::user();
        // if ($user->hasRole('admin') && $leaveRequest->company_id === $user->company_id) return;
        // if ($user->employee && $leaveRequest->employee_id === $user->employee->id) return;
        // if ($user->hasRole('manager')) {
        //     $dept = \App\Models\Department::where('manager_id', $user->id)->first();
        //     if ($dept && $leaveRequest->employee->department_id === $dept->id) return;
        // }
        // abort(403);
    }

    private function authorizeApproval(LeaveRequest $leaveRequest)
    {
        $user = Auth::user();
    if ($user->hasRole('admin') && $leaveRequest->company_id === $user->company_id) return;

    if ($user->hasRole('manager')) {
        $dept = \App\Models\Department::where('manager_id', $user->id)->first();
        if ($dept && $leaveRequest->employee->department_id === $dept->id) return;
    }

    abort(403);
        // $user = Auth::user();
        // if ($user->hasRole('admin') && $leaveRequest->company_id === $user->company_id) return;
        // if ($user->hasRole('manager')) {
        //     $dept = \App\Models\Department::where('manager_id', $user->id)->first();
        //     if ($dept && $leaveRequest->employee->department_id === $dept->id) return;
        // }
        // abort(403);
    }
}