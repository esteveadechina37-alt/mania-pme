<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use App\Models\Department;
use App\Models\LeaveRequest;
use App\Models\Evaluation;
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

        // Employés paginés
        $employees = Employee::where('company_id', $companyId)
                    ->whereNull('deleted_at')
                    ->with('user', 'department')
                    ->orderBy('status')
                    ->paginate(15);

        // Statistiques KPI
        $totalEmployees = Employee::where('company_id', $companyId)->count();
        $activeCount    = Employee::where('company_id', $companyId)->where('status', 'active')->count();
        $onLeaveCount   = Employee::where('company_id', $companyId)->whereHas('leaveRequests', function ($q) {
                            $today = now()->toDateString();
                            $q->where('status', 'approved')
                            ->where('start_date', '<=', $today)
                            ->where('end_date', '>=', $today);
                        })->count();
        $departmentsCount = Department::where('company_id', $companyId)->count();

        // Top 5 employés les mieux évalués (moyenne ou dernière note)
        $topEvaluated = Employee::where('company_id', $companyId)
                        ->where('status', 'active')
                        ->whereNull('deleted_at')
                        ->with(['user', 'evaluations' => function ($q) {
                            $q->latest('evaluated_at')->limit(1);
                        }])
                        ->get()
                        ->filter(function ($emp) {
                            return $emp->evaluations->isNotEmpty();
                        })
                        ->sortByDesc(function ($emp) {
                            return $emp->evaluations->first()->score;
                        })
                        ->take(5);

        return view('admin.employees.index', compact(
            'employees',
            'totalEmployees',
            'activeCount',
            'onLeaveCount',
            'departmentsCount',
            'topEvaluated'
        ));
    }
    // public function index()
    // {
    //     $companyId = auth()->user()->company_id;
    //     $today = now()->toDateString();

    //     // Tous les employés non supprimés (soft delete), avec leur user et département
    //     $employees = Employee::where('company_id', $companyId)
    //                 ->whereNull('deleted_at')
    //                 ->with('user', 'department')
    //                 ->orderBy('status')
    //                 ->paginate(15);

    //     // Statistiques dynamiques
    //     $totalEmployees = Employee::where('company_id', $companyId)->count(); // tous, sauf soft-deleted
    //     $activeCount    = Employee::where('company_id', $companyId)->where('status', 'active')->count();

    //     // Employés en congé : ceux ayant une demande approuvée couvrant la date du jour
    //     $onLeaveCount = Employee::where('company_id', $companyId)
    //         ->whereHas('leaveRequests', function ($query) use ($today) {
    //             $query->where('status', 'approved')
    //                 ->where('start_date', '<=', $today)
    //                 ->where('end_date', '>=', $today);
    //         })
    //         ->count();

    //     $departmentsCount = \App\Models\Department::where('company_id', $companyId)->count();

    //     return view('admin.employees.index', compact(
    //         'employees',
    //         'totalEmployees',
    //         'activeCount',
    //         'onLeaveCount',
    //         'departmentsCount'
    //     ));
    // }

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
            'hire_date' => 'required|date',
            // 'contract_end_date' => 'nullable|date',
                'contract_end_date' => [
            'nullable',
            'date',
            function ($attribute, $value, $fail) use ($request) {
                if ($value && $request->hire_date && $value <= $request->hire_date) {
                    $fail('La date de fin du contrat doit être postérieure à la date d\'embauche.');
                }
            },
        ],
            'role' => 'required|in:manager,employe,stagiaire',
        ]);

        // 1. Créer l'utilisateur
        $user = new User();
        $user->company_id = auth()->user()->company_id;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->is_active = true;
        $user->must_change_password = true;
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

        // Synchronisation du statut en fonction de la date d'embauche
if ($employee->hire_date && now()->startOfDay()->lt(\Carbon\Carbon::parse($employee->hire_date)->startOfDay())) {
    $employee->update(['status' => 'inactive']);
    $user->update(['is_active' => false]);
} else {
    $employee->update(['status' => 'active']);
    $user->update(['is_active' => true]);
}

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
            // 'hire_date' => 'required|date',
            'contract_end_date' => [
        'nullable',
        'date',
        function ($attribute, $value, $fail) use ($request) {
            if ($value && $request->hire_date && $value <= $request->hire_date) {
                $fail('La date de fin du contrat doit être postérieure à la date d\'embauche.');
            }
        },
    ],
            // 'contract_end_date' => 'nullable|date',
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
            // 'hire_date' => $request->hire_date,
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


    public function showImportForm()
{
    return view('admin.employees.import');
}
public function import(Request $request)
{
    $request->validate([
        'csv_file' => 'required|file|mimes:csv,txt',
    ]);

    $file = $request->file('csv_file');
    $path = $file->getRealPath();
    $data = array_map('str_getcsv', file($path));
    $header = array_shift($data);

    // Mapping des colonnes (français / anglais) → clé utilisée en interne
    $mapping = [
        'nom'               => 'name',
        'name'              => 'name',
        'email'             => 'email',
        'courriel'          => 'email',
        'mot de passe'      => 'password',
        'mot_de_passe'      => 'password',
        'password'          => 'password',
        'rôle'              => 'role',
        'role'              => 'role',
        'date d\'embauche'   => 'hire_date',
        'date_embauche'     => 'hire_date',
        'hire_date'         => 'hire_date',
        'date de fin'       => 'contract_end_date',
        'date_fin'          => 'contract_end_date',
        'contract_end_date' => 'contract_end_date',
        'salaire'           => 'salary',
        'salary'            => 'salary',
    ];

    // Nettoyer les en-têtes et les faire correspondre
    $normalizedHeader = [];
    foreach ($header as $col) {
        $col = trim(strtolower($col));
        if (isset($mapping[$col])) {
            $normalizedHeader[] = $mapping[$col];
        } else {
            $normalizedHeader[] = null; // colonne inconnue → ignorée
        }
    }

    $imported = 0;
    $errors   = [];

    foreach ($data as $index => $row) {
        if (count($row) !== count($header)) {
            $errors[] = "Ligne " . ($index + 2) . " ignorée : nombre de colonnes incorrect.";
            continue;
        }

        // Construire le tableau associatif avec les clés mappées
        $rowAssoc = [];
        foreach ($normalizedHeader as $i => $key) {
            if ($key !== null) {
                $rowAssoc[$key] = $row[$i] ?? '';
            }
        }

        // Champs obligatoires
        $name  = trim($rowAssoc['name'] ?? '');
        $email = trim($rowAssoc['email'] ?? '');
        if (empty($name) || empty($email)) {
            $errors[] = "Ligne " . ($index + 2) . " ignorée : nom ou email manquant.";
            continue;
        }

        // Vérifier doublon email
        if (\App\Models\User::where('email', $email)->exists()) {
            $errors[] = "Ligne " . ($index + 2) . " ($email) ignorée : email déjà utilisé.";
            continue;
        }

        // Valeurs par défaut
        $password        = ($rowAssoc['password'] ?? '') !== '' ? $rowAssoc['password'] : 'Default123!';
        $roleName        = ($rowAssoc['role'] ?? '') !== '' ? $rowAssoc['role'] : 'employe';
        $hireDate        = ($rowAssoc['hire_date'] ?? '') !== '' ? $rowAssoc['hire_date'] : now()->toDateString();
        $contractEndDate = ($rowAssoc['contract_end_date'] ?? '') !== '' ? $rowAssoc['contract_end_date'] : null;
        $salary          = ($rowAssoc['salary'] ?? '') !== '' ? floatval($rowAssoc['salary']) : 0;

        // Créer l'utilisateur
        $user = \App\Models\User::create([
            'name'                 => $name,
            'email'                => $email,
            'password'             => bcrypt($password),
            'company_id'           => auth()->user()->company_id,
            'is_active'            => true,
            'must_change_password' => true,
        ]);

        $user->assignRole($roleName);

        // Déterminer le statut
        $hireDateCarbon = \Carbon\Carbon::parse($hireDate)->startOfDay();
        $status = now()->startOfDay()->lt($hireDateCarbon) ? 'inactive' : 'active';

        if ($status === 'inactive') {
            $user->update(['is_active' => false]);
        }

        // Créer l'employé
        \App\Models\Employee::create([
            'user_id'           => $user->id,
            'company_id'        => auth()->user()->company_id,
            'department_id'     => null, // pas de département dans l'import
            'position'          => null, // pas de poste dans l'import
            'hire_date'         => $hireDate,
            'contract_end_date' => $contractEndDate,
            'salary'            => $salary,
            'status'            => $status,
        ]);

        $imported++;
    }

    $message = "$imported employé(s) importé(s) avec succès.";
    if (count($errors) > 0) {
        $message .= ' Cependant, ' . count($errors) . ' ligne(s) ont été ignorées.';
        session()->flash('import_errors', $errors);
    }

    return redirect()->route('admin.employees.index')
        ->with('success', $message);
}
    // public function import(Request $request)
    // {
    //     $request->validate([
    //         'csv_file' => 'required|file|mimes:csv,txt',
    //     ]);

    //     $file = $request->file('csv_file');
    //     $path = $file->getRealPath();
    //     $data = array_map('str_getcsv', file($path));
    //     $header = array_shift($data); // première ligne = en-têtes

    //     $imported = 0;
    //     foreach ($data as $row) {
    //         if (count($row) !== count($header)) continue;
    //         $rowAssoc = array_combine($header, $row);

    //         // Créer l'utilisateur
    //         $user = \App\Models\User::create([
    //             'name'       => $rowAssoc['name'] ?? 'Sans nom',
    //             'email'      => $rowAssoc['email'],
    //             'password'   => bcrypt($rowAssoc['password'] ?? 'default123'),
    //             'company_id' => auth()->user()->company_id,
    //             'is_active'  => true,
    //             'must_change_password' => true, // obligera à changer à la 1ère connexion
    //         ]);

    //         // Assigner le rôle (par défaut 'employe')
    //         $roleName = $rowAssoc['role'] ?? 'employe';
    //         $user->assignRole($roleName);

    //         // Créer l'employé
    //         \App\Models\Employee::create([
    //             'user_id'           => $user->id,
    //             'company_id'        => auth()->user()->company_id,
    //             'department_id'     => $rowAssoc['department_id'] ?? null,
    //             'position'          => $rowAssoc['position'] ?? null,
    //             'hire_date'         => $rowAssoc['hire_date'] ?? now(),
    //             'contract_end_date' => $rowAssoc['contract_end_date'] ?? null,
    //             'salary'            => $rowAssoc['salary'] ?? 0,
    //             'status'            => 'active',
    //         ]);

    //         $imported++;
    //     }

    //     return redirect()->route('admin.employees.index')
    //         ->with('success', "$imported employé(s) importé(s).");
    // }
}