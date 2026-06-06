<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use App\Models\Department;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    // public function index()
    // {
    //     $companyId = auth()->user()->company_id;
    //     $employees = Employee::where('company_id', $companyId)
    //                   ->with('user', 'department')
    //                   ->paginate(15);
    //     return view('admin.employees.index', compact('employees'));
    // }
    // public function index()
    //     {
    //         $companyId = auth()->user()->company_id;

    //         // Liste des employés paginée
    //         $employees = Employee::where('company_id', $companyId)
    //                     ->with('user', 'department')
    //                     ->paginate(15);

    //         // Statistiques dynamiques
    //         $totalEmployees = $employees->total(); // nombre total d'employés (tient compte de la pagination)
    //         $activeCount    = Employee::where('company_id', $companyId)->where('status', 'active')->count();
    //         $onLeaveCount   = 0; // sera calculé plus tard avec la table leave_requests
    //         $departmentsCount = \App\Models\Department::where('company_id', $companyId)->count();

    //         return view('admin.employees.index', compact(
    //             'employees',
    //             'totalEmployees',
    //             'activeCount',
    //             'onLeaveCount',
    //             'departmentsCount'
    //         ));
    //     }

    // public function index()
    // {
    //     $companyId = auth()->user()->company_id;

    //     // Tous les employés non supprimés (soft delete), avec leur utilisateur et département
    //     $employees = Employee::where('company_id', $companyId)
    //                 ->whereNull('deleted_at') // sécurité, normalement automatique
    //                 ->with('user', 'department')
    //                 ->orderBy('status') // pour grouper éventuellement
    //                 ->paginate(15);

    //     // Statistiques
    //     $totalEmployees = Employee::where('company_id', $companyId)->count(); // total non supprimés
    //     $activeCount    = Employee::where('company_id', $companyId)->where('status', 'active')->count();
    //     $onLeaveCount   = 0; // plus tard
    //     $departmentsCount = \App\Models\Department::where('company_id', $companyId)->count();

    //     return view('admin.employees.index', compact(
    //         'employees',
    //         'totalEmployees',
    //         'activeCount',
    //         'onLeaveCount',
    //         'departmentsCount'
    //     ));
    // }
    public function index()
    {
        $companyId = auth()->user()->company_id;
        $today = now()->toDateString();

        // Tous les employés non supprimés (soft delete), avec leur user et département
        $employees = Employee::where('company_id', $companyId)
                    ->whereNull('deleted_at')
                    ->with('user', 'department')
                    ->orderBy('status')
                    ->paginate(15);

        // Statistiques dynamiques
        $totalEmployees = Employee::where('company_id', $companyId)->count(); // tous, sauf soft-deleted
        $activeCount    = Employee::where('company_id', $companyId)->where('status', 'active')->count();

        // Employés en congé : ceux ayant une demande approuvée couvrant la date du jour
        $onLeaveCount = Employee::where('company_id', $companyId)
            ->whereHas('leaveRequests', function ($query) use ($today) {
                $query->where('status', 'approved')
                    ->where('start_date', '<=', $today)
                    ->where('end_date', '>=', $today);
            })
            ->count();

        $departmentsCount = \App\Models\Department::where('company_id', $companyId)->count();

        return view('admin.employees.index', compact(
            'employees',
            'totalEmployees',
            'activeCount',
            'onLeaveCount',
            'departmentsCount'
        ));
    }

    // public function index()
    // {
    //     $companyId = auth()->user()->company_id;

    //     // Liste des employés ACTIFS uniquement
    //     $employees = Employee::where('company_id', $companyId)
    //                 ->where('status', 'active')
    //                 ->with('user', 'department')
    //                 ->paginate(15);

    //     // Statistiques dynamiques (basées sur les actifs)
    //     $totalEmployees = $employees->total();        // total des actifs
    //     $activeCount    = $employees->total();        // identique ici (tous sont actifs)
    //     $onLeaveCount   = 0;                          // futur module congés
    //     $departmentsCount = \App\Models\Department::where('company_id', $companyId)->count();

    //     return view('admin.employees.index', compact(
    //         'employees',
    //         'totalEmployees',
    //         'activeCount',
    //         'onLeaveCount',
    //         'departmentsCount'
    //     ));
    // }

    public function create()
    {
        $companyId = auth()->user()->company_id;
        $departments = Department::where('company_id', $companyId)->get();
        return view('admin.employees.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'department_id' => 'nullable|exists:departments,id',
            'position' => 'nullable|string|max:255',
            'contract_type' => 'nullable|string',
            'salary' => 'nullable|numeric',
            'hire_date' => 'nullable|date',
            'contract_end_date' => 'nullable|date',
            'role' => 'required|in:manager,employe,stagiaire',
        ]);

        // 1. Créer l'utilisateur
        $user = new User();
        $user->company_id = auth()->user()->company_id;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->is_active = true;
        $user->save();
        $user->assignRole($request->role);

        // 2. Créer l'employé
        $employee = new Employee();
        $employee->user_id = $user->id;
        $employee->company_id = auth()->user()->company_id;
        $employee->department_id = $request->department_id;
        $employee->position = $request->position;
        $employee->contract_type = $request->contract_type;
        $employee->salary = $request->salary;
        $employee->hire_date = $request->hire_date;
        $employee->contract_end_date = $request->contract_end_date;
        $employee->save();

        return redirect()->route('admin.employees.index')
               ->with('success', 'Employé créé avec succès.');
    }

    // public function show(Employee $employee)
    // {
    //     $this->authorizeCompany($employee);
    //     $employee->load('user', 'department');
    //     return view('admin.employees.show', compact('employee'));
    // }
    public function show(Employee $employee)
    {
        $this->authorizeCompany($employee);
        $employee->load('user', 'department');

        // Vérifier si l'employé est en congé aujourd'hui
        $today = now()->toDateString();
        $currentLeave = $employee->leaveRequests()
            ->where('status', 'approved')
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->with('leaveType')
            ->first();

        return view('admin.employees.show', compact('employee', 'currentLeave'));
    }

    public function edit(Employee $employee)
    {
        $this->authorizeCompany($employee);
        $companyId = auth()->user()->company_id;
        $departments = Department::where('company_id', $companyId)->get();
        return view('admin.employees.edit', compact('employee', 'departments'));
    }

    public function update(Request $request, Employee $employee)
    {
        $this->authorizeCompany($employee);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$employee->user_id,
            'department_id' => 'nullable|exists:departments,id',
            'position' => 'nullable|string',
            'contract_type' => 'nullable|string',
            'salary' => 'nullable|numeric',
            'hire_date' => 'nullable|date',
            'contract_end_date' => 'nullable|date',
            'status' => 'required|in:active,suspended,terminated',
            'role' => 'required|in:manager,employe,stagiaire',
        ]);

        $user = $employee->user;
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->syncRoles([$request->role]);
        $user->save();

        $employee->update([
            'department_id' => $request->department_id,
            'position' => $request->position,
            'contract_type' => $request->contract_type,
            'salary' => $request->salary,
            'hire_date' => $request->hire_date,
            'contract_end_date' => $request->contract_end_date,
            'status' => $request->status
        ]);

        // --- AJOUT : Désassigner le département si le statut n'est plus actif ---
        if ($request->status !== 'active') {
            $employee->department_id = null;
            $employee->save();
        }

        // Synchronisation de l'état actif de l'utilisateur (déjà présente)
        $activeStatuses = ['active'];
        if (in_array($request->status, $activeStatuses)) {
            $employee->user->update(['is_active' => true]);
        } else {
            $employee->user->update(['is_active' => false]);
        }

        return redirect()->route('admin.employees.index')
               ->with('success', 'Employé mis à jour.');
    }

    // public function destroy(Employee $employee)
    // {
    //     $this->authorizeCompany($employee);

    //     // Désactiver l'utilisateur lié (optionnel, évite qu'il se connecte)
    //     $employee->user->update(['is_active' => false]);

    //     // Soft delete de l'employé uniquement
    //     $employee->delete();

    //     return redirect()->route('admin.employees.index')
    //         ->with('success', 'Employé supprimé (soft delete).');
    // }
    public function destroy(Employee $employee)
    {
        $this->authorizeCompany($employee);

        // Désactiver l'utilisateur lié (il ne pourra plus se connecter)
        if ($employee->user) {
            $employee->user->update(['is_active' => false]);
        }

        // Soft delete de l'employé (remplit deleted_at sans effacer la ligne)
        $employee->delete();

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employé supprimé (désactivé).');
    }

    // public function destroy(Employee $employee)
    // {
    //     $this->authorizeCompany($employee);
    //     $user = $employee->user;
    //     $employee->delete();
    //     $user->delete(); // supprime aussi l'utilisateur associé
    //     return redirect()->route('admin.employees.index')
    //            ->with('success', 'Employé supprimé.');
    // }

    private function authorizeCompany(Employee $employee)
    {
        if ($employee->company_id !== auth()->user()->company_id) {
            abort(403, 'Non autorisé.');
        }
    }

    public function search(Request $request)
    {
        $query = $request->query('query');
        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }

        $companyId = auth()->user()->company_id;
        $employees = Employee::where('company_id', $companyId)
            ->where('status', 'active')
            ->whereNull('deleted_at')
            ->whereHas('user', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->with('user', 'department')
            ->take(8)
            ->get()
            ->map(function ($emp) {
                return [
                    'id'         => $emp->id,
                    'name'       => $emp->user->name,
                    'position'   => $emp->position,
                    'department' => $emp->department?->name,
                ];
            });

        return response()->json($employees);
    }
}