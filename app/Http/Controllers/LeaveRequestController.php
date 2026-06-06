<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\Employee;
use App\Models\User;
use App\Models\Department;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\RhNotificationMail;
use Illuminate\Support\Facades\Mail;

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
        $today = now()->toDateString();

        // Vérifier si l'employé a déjà une demande en cours (approuvée ou en attente) non terminée
        $ongoingRequest = $employee->leaveRequests()
            ->whereIn('status', ['approved', 'pending'])
            ->where('end_date', '>=', $today)
            ->exists();

        if ($ongoingRequest) {
            return redirect()->route('leave-requests.index')
                ->with('error', 'Vous avez déjà une demande de congé en cours. Vous ne pouvez pas en soumettre une nouvelle avant la fin de celle-ci.');
        }

        $types = LeaveType::where('company_id', $employee->company_id)->get();
        return view('leave-requests.create', compact('types'));
    }
    // public function create()
    // {
    //     $employee = $this->getEmployee();

    //     // Vérifier si un congé approuvé est en cours
    //     $today = now()->toDateString();
    //     $ongoingLeave = $employee->leaveRequests()
    //         ->where('status', 'approved')
    //         ->where('start_date', '<=', $today)
    //         ->where('end_date', '>=', $today)
    //         ->exists();

    //     if ($ongoingLeave) {
    //         return redirect()->route('leave-requests.index')
    //             ->with('error', 'Vous êtes déjà en congé actuellement. Vous ne pouvez pas faire une nouvelle demande.');
    //     }

    //     $types = LeaveType::where('company_id', $employee->company_id)->get();
    //     return view('leave-requests.create', compact('types'));
    // }
    // public function create()
    // {
    //     $employee = $this->getEmployee();
    //     $types = LeaveType::where('company_id', $employee->company_id)->get();
    //     return view('leave-requests.create', compact('types'));
    // }

    // Soumettre une demande

    public function store(Request $request)
    {
        $employee = $this->getEmployee();
        $today = now()->toDateString();

        // Vérifier si l'employé a déjà une demande en cours (approuvée ou en attente) non terminée
        $ongoingRequest = $employee->leaveRequests()
            ->whereIn('status', ['approved', 'pending'])
            ->where('end_date', '>=', $today)
            ->exists();

        if ($ongoingRequest) {
            return back()->with('error', 'Vous avez déjà une demande de congé en cours. Vous ne pouvez pas en soumettre une nouvelle avant la fin de celle-ci.');
        }

        // Validation des champs
        $request->validate([
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date'    => 'required|date|after_or_equal:today',
            'end_date'      => 'required|date|after_or_equal:start_date',
            'reason'        => 'nullable|string',
        ]);

        // Vérifier le chevauchement avec les demandes existantes
        $overlap = $employee->leaveRequests()
            ->whereIn('status', ['approved', 'pending'])
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                    ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('start_date', '<=', $request->start_date)
                            ->where('end_date', '>=', $request->end_date);
                    });
            })
            ->exists();

        if ($overlap) {
            return back()->with('error', 'Les dates sélectionnées chevauchent une autre demande de congé.');
        }

        // Création de la demande
        LeaveRequest::create([
            'employee_id'   => $employee->id,
            'company_id'    => $employee->company_id,
            'leave_type_id' => $request->leave_type_id,
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,
            'reason'        => $request->reason,
            'status'        => 'pending',
        ]);

        // --- Notification au manager et aux admins ---
        $user = $employee->user;
        $title = 'Nouvelle demande de congé';
        $message = $user->name . ' a soumis une demande de congé du ' . $request->start_date . ' au ' . $request->end_date . '.';

        // Notification au manager du département
        $department = $employee->department;
        if ($department && $department->manager_id) {
            \App\Models\Notification::create([
                'user_id'    => $department->manager_id,
                'company_id' => $employee->company_id,
                'type'       => 'leave_requested',
                'title'      => $title,
                'message'    => $message,
            ]);
            try {
                Mail::to($department->manager->email)->send(new RhNotificationMail($title, $message, $department->manager->name));
            } catch (\Exception $e) {
                \Log::error("Erreur envoi mail manager : " . $e->getMessage());
            }
        }

        // Notification aux admins de l'entreprise
        $admins = \App\Models\User::where('company_id', $employee->company_id)
            ->whereHas('roles', fn($q) => $q->where('name', 'admin'))
            ->get();
        foreach ($admins as $admin) {
            \App\Models\Notification::create([
                'user_id'    => $admin->id,
                'company_id' => $employee->company_id,
                'type'       => 'leave_requested',
                'title'      => $title,
                'message'    => $message,
            ]);
            try {
                Mail::to($admin->email)->send(new RhNotificationMail($title, $message, $admin->name));
            } catch (\Exception $e) {
                \Log::error("Erreur envoi mail admin : " . $e->getMessage());
            }
        }

        return redirect()->route('leave-requests.index')->with('success', 'Demande soumise.');
    }
    // public function store(Request $request)
    // {
    //     $employee = $this->getEmployee();
    //     $today = now()->toDateString();
    //     $ongoingLeave = $employee->leaveRequests()
    //         ->where('status', 'approved')
    //         ->where('start_date', '<=', $today)
    //         ->where('end_date', '>=', $today)
    //         ->exists();

    //     if ($ongoingLeave) {
    //         return back()->with('error', 'Vous êtes déjà en congé actuellement. Vous ne pouvez pas soumettre une nouvelle demande.');
    //     }
    //     $request->validate([
    //         'leave_type_id' => 'required|exists:leave_types,id',
    //         'start_date'    => 'required|date|after_or_equal:today',
    //         'end_date'      => 'required|date|after_or_equal:start_date',
    //         'reason'        => 'nullable|string',
    //     ]);

    //     LeaveRequest::create([
    //         'employee_id'   => $employee->id,
    //         'company_id'    => $employee->company_id,
    //         'leave_type_id' => $request->leave_type_id,
    //         'start_date'    => $request->start_date,
    //         'end_date'      => $request->end_date,
    //         'reason'        => $request->reason,
    //         'status'        => 'pending',
    //     ]);

    //     $employee = $this->getEmployee();
    //     $user = $employee->user;

    //     $title = 'Nouvelle demande de congé';
    //     $message = $user->name . ' a soumis une demande de congé du ' . $request->start_date . ' au ' . $request->end_date . '.';

    //     // Notification au manager du département
    //     $department = $employee->department;
    //     if ($department && $department->manager_id) {
    //         Notification::create([
    //             'user_id'    => $department->manager_id,
    //             'company_id' => $employee->company_id,
    //             'type'       => 'leave_requested',
    //             'title'      => $title,
    //             'message'    => $message,
    //         ]);

    //         try {
    //             Mail::to($department->manager->email)->send(new RhNotificationMail($title, $message, $department->manager->name));
    //         } catch (\Exception $e) {
    //             \Log::error("Erreur envoi mail manager : " . $e->getMessage());
    //         }
    //     }

    //     // Notification aux admins de l'entreprise
    //     $admins = \App\Models\User::where('company_id', $employee->company_id)
    //         ->whereHas('roles', fn($q) => $q->where('name', 'admin'))
    //         ->get();

    //     foreach ($admins as $admin) {
    //         Notification::create([
    //             'user_id'    => $admin->id,
    //             'company_id' => $employee->company_id,
    //             'type'       => 'leave_requested',
    //             'title'      => $title,
    //             'message'    => $message,
    //         ]);

    //         try {
    //             Mail::to($admin->email)->send(new RhNotificationMail($title, $message, $admin->name));
    //         } catch (\Exception $e) {
    //             \Log::error("Erreur envoi mail admin : " . $e->getMessage());
    //         }
    //     }

    //     return redirect()->route('leave-requests.index')->with('success', 'Demande soumise.');
    // }

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

        $employee = $leaveRequest->employee;
        $user = $employee->user;

        $title = $request->decision == 'approved' ? 'Congé approuvé' : 'Congé refusé';
        $message = $request->decision == 'approved'
            ? "Votre demande de congé du {$leaveRequest->start_date->format('d/m')} au {$leaveRequest->end_date->format('d/m')} a été approuvée."
            : "Votre demande de congé du {$leaveRequest->start_date->format('d/m')} au {$leaveRequest->end_date->format('d/m')} a été refusée.";

        // Notification à l'employé
        \App\Models\Notification::create([
            'user_id'    => $user->id,
            'company_id' => $user->company_id,
            'type'       => $request->decision == 'approved' ? 'leave_approved' : 'leave_rejected',
            'title'      => $title,
            'message'    => $message,
        ]);

        try {
            Mail::to($user->email)->send(new RhNotificationMail($title, $message, $user->name));
        } catch (\Exception $e) {
            \Log::error("Erreur envoi mail employé : " . $e->getMessage());
        }

        // Notification aux administrateurs de l'entreprise
        $adminTitle = 'Congé ' . ($request->decision == 'approved' ? 'approuvé' : 'refusé') . ' par le manager';
        $adminMessage = "La demande de congé de {$user->name} (du {$leaveRequest->start_date->format('d/m')} au {$leaveRequest->end_date->format('d/m')}) a été " . 
            ($request->decision == 'approved' ? 'approuvée' : 'refusée') . " par " . auth()->user()->name . ".";

        $admins = \App\Models\User::where('company_id', $user->company_id)
            ->whereHas('roles', fn($q) => $q->where('name', 'admin'))
            ->get();

        foreach ($admins as $admin) {
            \App\Models\Notification::create([
                'user_id'    => $admin->id,
                'company_id' => $user->company_id,
                'type'       => $request->decision == 'approved' ? 'leave_approved' : 'leave_rejected',
                'title'      => $adminTitle,
                'message'    => $adminMessage,
            ]);

            try {
                Mail::to($admin->email)->send(new RhNotificationMail($adminTitle, $adminMessage, $admin->name));
            } catch (\Exception $e) {
                \Log::error("Erreur envoi mail admin : " . $e->getMessage());
            }
        }

        // $employee = $leaveRequest->employee;
        // $user = $employee->user;

        // $title = $request->decision == 'approved' ? 'Congé approuvé' : 'Congé refusé';
        // $message = $request->decision == 'approved'
        //     ? "Votre demande de congé du {$leaveRequest->start_date->format('d/m')} au {$leaveRequest->end_date->format('d/m')} a été approuvée."
        //     : "Votre demande de congé du {$leaveRequest->start_date->format('d/m')} au {$leaveRequest->end_date->format('d/m')} a été refusée.";

        // \App\Models\Notification::create([
        //     'user_id'    => $user->id,
        //     'company_id' => $user->company_id,
        //     'type'       => $request->decision == 'approved' ? 'leave_approved' : 'leave_rejected',
        //     'title'      => $title,
        //     'message'    => $message,
        // ]);

        // try {
        //     Mail::to($user->email)->send(new RhNotificationMail($title, $message, $user->name));
        // } catch (\Exception $e) {
        //     \Log::error("Erreur envoi mail : " . $e->getMessage());
        // }

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