<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Vérifie que le département appartient bien à l'entreprise connectée.
     */
    private function authorizeCompany(Department $department)
    {
        if ($department->company_id !== auth()->user()->company_id) {
            abort(403, 'Non autorisé.');
        }
    }

    public function index()
    {
        $companyId = auth()->user()->company_id;
        // $departments = Department::where('company_id', $companyId)
        //                 ->with('manager')
        //                 ->withCount('employees')
        //                 ->paginate(15);
        $departments = Department::where('company_id', $companyId)
                ->with('manager')
                ->withCount(['employees' => function ($query) {
                    $query->where('status', 'active')
                          ->whereNull('deleted_at');
                }])
                ->paginate(15);

        return view('admin.departments.index', compact('departments'));
    }

    public function create()
    {
        // Récupère les managers possibles (utilisateurs ayant le rôle manager dans la même boîte)
        // $managers = User::where('company_id', auth()->user()->company_id)
        //              ->whereHas('roles', fn($q) => $q->where('name', 'manager'))
        //              ->get();
        $managers = User::where('company_id', auth()->user()->company_id)
            ->where('is_active', true)
            ->whereHas('roles', fn($q) => $q->where('name', 'manager'))
            ->get();

        return view('admin.departments.create', compact('managers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'manager_id'  => 'nullable|exists:users,id',
            'description' => 'nullable|string',
        ]);

        // 🔒 Vérification : ce manager est-il déjà assigné ailleurs ?
        if ($request->manager_id) {
            $exists = Department::where('manager_id', $request->manager_id)->exists();
            if ($exists) {
                return back()->withErrors([
                    'manager_id' => 'Cet utilisateur est déjà manager d’un autre département.',
                ])->withInput();
            }
        }

        $department = Department::create([
            'company_id' => auth()->user()->company_id,
            ...$validated,
        ]);

        // Synchronisation avec la fiche employé
        if ($department->manager_id) {
            $employee = Employee::where('user_id', $department->manager_id)
                         ->where('company_id', $department->company_id)
                         ->first();
            if ($employee) {
                $employee->department_id = $department->id;
                $employee->save();
            } else {
                Employee::create([
                    'user_id'       => $department->manager_id,
                    'company_id'    => $department->company_id,
                    'department_id' => $department->id,
                    'position'      => 'Manager',
                    'status'        => 'active',
                    'hire_date'     => now(),
                ]);
            }
        }

        return redirect()->route('admin.departments.index')
                         ->with('success', 'Département créé avec succès.');
    }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'manager_id' => 'nullable|exists:users,id',
    //         'description' => 'nullable|string',
    //     ]);

    //      // 🔽 INSÈRE LE CODE ICI
    //     if ($request->manager_id) {
    //         $exists = Department::where('manager_id', $request->manager_id)->exists();
    //         if ($exists) {
    //             return back()->withErrors(['manager_id' => 'Cet utilisateur est déjà manager d’un autre département.']);
    //         }
    //     }

    //     $department = Department::create([
    //         'company_id' => auth()->user()->company_id,
    //         ...$validated,
    //     ]);

    //     // ✅ Mise à jour de l'employé du manager pour lui attribuer ce département
    //     if ($department->manager_id) {
    //         $employee = Employee::where('user_id', $department->manager_id)
    //                     ->where('company_id', $department->company_id)
    //                     ->first();

    //         if ($employee) {
    //             // Le manager a déjà une fiche employé → on l’associe au département
    //             $employee->department_id = $department->id;
    //             $employee->save();
    //         } else {
    //             // Le manager n'a pas encore de fiche employé → on la crée
    //             Employee::create([
    //                 'user_id'       => $department->manager_id,
    //                 'company_id'    => $department->company_id,
    //                 'department_id' => $department->id,
    //                 'position'      => 'Manager',
    //                 'status'        => 'active',
    //                 'hire_date'     => now(),
    //             ]);
    //         }
    //     }

    //     return redirect()->route('admin.departments.index')
    //                     ->with('success', 'Département créé.');
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255|unique:departments,name,NULL,id,company_id,'.auth()->user()->company_id,
    //         'description' => 'nullable|string|max:1000',
    //         'manager_id' => 'nullable|exists:users,id',
    //     ]);

    //     Department::create([
    //         'company_id' => auth()->user()->company_id,
    //         'name' => $request->name,
    //         'description' => $request->description,
    //         'manager_id' => $request->manager_id,
    //     ]);

    //     return redirect()->route('admin.departments.index')
    //            ->with('success', 'Département créé avec succès.');
    // }

    public function show(Department $department)
    {
        $this->authorizeCompany($department);
        $department->load('manager');
        $department->load(['employees' => function ($query) {
            $query->where('status', 'active')
                ->whereNull('deleted_at')
                ->with('user');
        }]);

        return view('admin.departments.show', compact('department'));
    }

    // public function show(Department $department)
    // {
    //     $this->authorizeCompany($department);
    //     $department->load('manager', 'employees.user');

    //     return view('admin.departments.show', compact('department'));
    // }

    public function edit(Department $department)
    {
        $this->authorizeCompany($department);

        // $managers = User::where('company_id', auth()->user()->company_id)
        //              ->whereHas('roles', fn($q) => $q->where('name', 'manager'))
        //              ->get();
        $managers = User::where('company_id', auth()->user()->company_id)
            ->where('is_active', true)
            ->whereHas('roles', fn($q) => $q->where('name', 'manager'))
            ->get();

        return view('admin.departments.edit', compact('department', 'managers'));
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'manager_id'  => 'nullable|exists:users,id',
            'description' => 'nullable|string',
        ]);

        // 🔒 Vérification : ce manager est-il déjà assigné ailleurs ?
        if ($request->manager_id) {
            $exists = Department::where('manager_id', $request->manager_id)
                        ->where('id', '!=', $department->id) // exclut le département en cours
                        ->exists();
            if ($exists) {
                return back()->withErrors([
                    'manager_id' => 'Cet utilisateur est déjà manager d’un autre département.',
                ])->withInput();
            }
        }

        $department->update($validated);

        // Synchronisation avec la fiche employé
        if ($department->manager_id) {
            $employee = Employee::where('user_id', $department->manager_id)
                         ->where('company_id', $department->company_id)
                         ->first();
            if ($employee) {
                $employee->department_id = $department->id;
                $employee->save();
            } else {
                Employee::create([
                    'user_id'       => $department->manager_id,
                    'company_id'    => $department->company_id,
                    'department_id' => $department->id,
                    'position'      => 'Manager',
                    'status'        => 'active',
                    'hire_date'     => now(),
                ]);
            }
        }

        return redirect()->route('admin.departments.show', $department)
                         ->with('success', 'Département mis à jour.');
    }

    // public function update(Request $request, Department $department)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'manager_id' => 'nullable|exists:users,id',
    //         'description' => 'nullable|string',
    //     ]);

    //     if ($request->manager_id) {
    //         $exists = Department::where('manager_id', $request->manager_id)
    //                     ->where('id', '!=', $department->id) // exclut le département en cours d'édition
    //                     ->exists();
    //         if ($exists) {
    //             return back()->withErrors(['manager_id' => 'Cet utilisateur est déjà manager d’un autre département.']);
    //         }
    //     }

    //     $department->update($validated);

    //     // ✅ Mise à jour de l'employé du manager pour lui attribuer ce département
    //     if ($department->manager_id) {
    //         $employee = Employee::where('user_id', $department->manager_id)
    //                     ->where('company_id', $department->company_id)
    //                     ->first();

    //         if ($employee) {
    //             // Met à jour le département de l'employé existant
    //             $employee->department_id = $department->id;
    //             $employee->save();
    //         } else {
    //             // Crée une fiche employé si elle n'existe pas
    //             Employee::create([
    //                 'user_id'       => $department->manager_id,
    //                 'company_id'    => $department->company_id,
    //                 'department_id' => $department->id,
    //                 'position'      => 'Manager',
    //                 'status'        => 'active',
    //                 'hire_date'     => now(),
    //             ]);
    //         }
    //     }

    //     return redirect()->route('admin.departments.show', $department)
    //                     ->with('success', 'Département modifié.');
    // }

    // public function update(Request $request, Department $department)
    // {
    //     $this->authorizeCompany($department);

    //     $request->validate([
    //         'name' => 'required|string|max:255|unique:departments,name,'.$department->id.',id,company_id,'.auth()->user()->company_id,
    //         'description' => 'nullable|string|max:1000',
    //         'manager_id' => 'nullable|exists:users,id',
    //     ]);

    //     $department->update([
    //         'name' => $request->name,
    //         'description' => $request->description,
    //         'manager_id' => $request->manager_id,
    //     ]);

    //     return redirect()->route('admin.departments.index')
    //            ->with('success', 'Département mis à jour.');
    // }

    public function destroy(Department $department)
    {
        $this->authorizeCompany($department);
        $department->delete();

        return redirect()->route('admin.departments.index')
               ->with('success', 'Département supprimé.');
    }
}