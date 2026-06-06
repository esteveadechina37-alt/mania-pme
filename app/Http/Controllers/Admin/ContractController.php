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

        // Filtre : expirant dans X jours
        if ($request->has('expiring_within')) {
            $days = (int) $request->expiring_within;
            if ($days > 0) {
                $query->where('contract_end_date', '<=', now()->addDays($days))
                      ->where('contract_end_date', '>=', now());
            }
        }

        // Filtre par statut
        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->where('status', 'active');
            } elseif ($request->status === 'terminated') {
                $query->where('status', 'terminated');
            }
        }

        $employees = $query->orderBy('contract_end_date')->paginate(15);

        return view('admin.contracts.index', compact('employees'));
    }
}