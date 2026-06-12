<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;

class DashboardController extends Controller
{
    public function index()
    {
        $companies = Company::withCount([
            'employees',
            'departments',
            'users as managers_count' => fn($q) => $q->whereHas('roles', fn($r) => $r->where('name', 'manager'))
        ])
        ->latest()
        ->get();

        $totalCompanies = $companies->count();
        $totalEmployees = $companies->sum('employees_count');
        $totalDepartments = $companies->sum('departments_count');
        $totalManagers = $companies->sum('managers_count');

        return view('super-admin.dashboard', compact(
            'companies',
            'totalCompanies',
            'totalEmployees',
            'totalDepartments',
            'totalManagers'
        ));
    }

        public function searchCompanies(Request $request)
    {
        $query = $request->query('query');
        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }

        $companies = Company::where('name', 'like', "%{$query}%")
                        ->take(8)
                        ->get(['id', 'name']);

        return response()->json($companies);
    }

        public function showCompany(Company $company)
    {
        $company->loadCount(['employees', 'departments', 'users as managers_count' => fn($q) => $q->whereHas('roles', fn($r) => $r->where('name', 'manager'))]);
        return view('super-admin.company-detail', compact('company'));
    }
}