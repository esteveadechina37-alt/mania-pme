<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $companyId = auth()->user()->company_id;
        $employees = Employee::where('company_id', $companyId)
                      ->with('user', 'department')
                      ->paginate(15);
        return view('admin.employees.index', compact('employees'));
    }

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
        $employee->save();

        return redirect()->route('admin.employees.index')
               ->with('success', 'Employé créé avec succès.');
    }

    public function show(Employee $employee)
    {
        $this->authorizeCompany($employee);
        $employee->load('user', 'department');
        return view('admin.employees.show', compact('employee'));
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
            'status' => $request->status
        ]);

        return redirect()->route('admin.employees.index')
               ->with('success', 'Employé mis à jour.');
    }

    public function destroy(Employee $employee)
    {
        $this->authorizeCompany($employee);
        $user = $employee->user;
        $employee->delete();
        $user->delete(); // supprime aussi l'utilisateur associé
        return redirect()->route('admin.employees.index')
               ->with('success', 'Employé supprimé.');
    }

    private function authorizeCompany(Employee $employee)
    {
        if ($employee->company_id !== auth()->user()->company_id) {
            abort(403, 'Non autorisé.');
        }
    }
}