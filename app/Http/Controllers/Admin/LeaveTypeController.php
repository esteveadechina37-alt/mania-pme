<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{
    private function authorizeCompany(LeaveType $leaveType)
    {
        if ($leaveType->company_id !== auth()->user()->company_id) {
            abort(403);
        }
    }

    public function index()
    {
        $types = LeaveType::where('company_id', auth()->user()->company_id)->paginate(15);
        return view('admin.leave-types.index', compact('types'));
    }

    public function create()
    {
        return view('admin.leave-types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'days_allowed' => 'required|integer|min:1',
            'paid'         => 'boolean',
        ]);

        LeaveType::create([
            'company_id'   => auth()->user()->company_id,
            'name'         => $request->name,
            'days_allowed' => $request->days_allowed,
            'paid'         => $request->paid ?? true,
        ]);

        return redirect()->route('admin.leave-types.index')->with('success', 'Type de congé créé.');
    }

    public function edit(LeaveType $leaveType)
    {
        $this->authorizeCompany($leaveType);
        return view('admin.leave-types.edit', compact('leaveType'));
    }

    public function update(Request $request, LeaveType $leaveType)
    {
        $this->authorizeCompany($leaveType);
        $request->validate([
            'name'         => 'required|string|max:255',
            'days_allowed' => 'required|integer|min:1',
            'paid'         => 'boolean',
        ]);

        $leaveType->update($request->only('name', 'days_allowed', 'paid'));
        return redirect()->route('admin.leave-types.index')->with('success', 'Type de congé mis à jour.');
    }

    public function destroy(LeaveType $leaveType)
    {
        $this->authorizeCompany($leaveType);
        $leaveType->delete();
        return redirect()->route('admin.leave-types.index')->with('success', 'Type de congé supprimé.');
    }
}