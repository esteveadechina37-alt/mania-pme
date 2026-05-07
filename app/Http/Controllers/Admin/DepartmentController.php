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
        $departments = Department::where('company_id', $companyId)
                        ->with('manager')
                        ->withCount('employees')
                        ->paginate(15);

        return view('admin.departments.index', compact('departments'));
    }

    public function create()
    {
        // Récupère les managers possibles (utilisateurs ayant le rôle manager dans la même boîte)
        $managers = User::where('company_id', auth()->user()->company_id)
                     ->whereHas('roles', fn($q) => $q->where('name', 'manager'))
                     ->get();

        return view('admin.departments.create', compact('managers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,NULL,id,company_id,'.auth()->user()->company_id,
            'description' => 'nullable|string|max:1000',
            'manager_id' => 'nullable|exists:users,id',
        ]);

        Department::create([
            'company_id' => auth()->user()->company_id,
            'name' => $request->name,
            'description' => $request->description,
            'manager_id' => $request->manager_id,
        ]);

        return redirect()->route('admin.departments.index')
               ->with('success', 'Département créé avec succès.');
    }

    public function show(Department $department)
    {
        $this->authorizeCompany($department);
        $department->load('manager', 'employees.user');

        return view('admin.departments.show', compact('department'));
    }

    public function edit(Department $department)
    {
        $this->authorizeCompany($department);

        $managers = User::where('company_id', auth()->user()->company_id)
                     ->whereHas('roles', fn($q) => $q->where('name', 'manager'))
                     ->get();

        return view('admin.departments.edit', compact('department', 'managers'));
    }

    public function update(Request $request, Department $department)
    {
        $this->authorizeCompany($department);

        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,'.$department->id.',id,company_id,'.auth()->user()->company_id,
            'description' => 'nullable|string|max:1000',
            'manager_id' => 'nullable|exists:users,id',
        ]);

        $department->update([
            'name' => $request->name,
            'description' => $request->description,
            'manager_id' => $request->manager_id,
        ]);

        return redirect()->route('admin.departments.index')
               ->with('success', 'Département mis à jour.');
    }

    public function destroy(Department $department)
    {
        $this->authorizeCompany($department);
        $department->delete();

        return redirect()->route('admin.departments.index')
               ->with('success', 'Département supprimé.');
    }
}