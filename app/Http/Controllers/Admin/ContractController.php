<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index(Request $request)
    {
        $companyId = auth()->user()->company_id;
        $query = Employee::where('company_id', $companyId)
                  ->whereNotNull('contract_type')
                  ->whereNull('deleted_at')
                  ->with('user', 'department');

        // Recherche par nom
        if ($search = $request->search) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%"));
        }

        // Échéance
        if ($request->filled('expiring_within')) {
            $days = (int) $request->expiring_within;
            if ($days > 0) {
                $query->where('contract_end_date', '<=', now()->addDays($days))
                      ->where('contract_end_date', '>=', now());
            }
        }

        // Statut employé
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Type de contrat
        if ($request->filled('contract_type')) {
            $query->where('contract_type', $request->contract_type);
        }

        $employees = $query->orderBy('contract_end_date')->paginate(15)->appends($request->all());

        // KPI
        $active   = $employees->getCollection()->where('status', 'active')->count();
        $expiring = $employees->getCollection()->filter(function ($emp) {
            if (!$emp->contract_end_date) return false;
            $end = \Carbon\Carbon::parse($emp->contract_end_date)->startOfDay();
            $now = now()->startOfDay();
            return !$end->isPast() && $end->between($now->copy()->addDay(), $now->copy()->addDays(30)->endOfDay());
        })->count();
        $expired  = $employees->getCollection()->filter(fn($emp) => $emp->contract_end_date && \Carbon\Carbon::parse($emp->contract_end_date)->startOfDay()->isPast())->count();

        return view('admin.contracts.index', compact('employees', 'active', 'expiring', 'expired'));
    }
}