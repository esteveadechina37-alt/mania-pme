<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveType;
use App\Models\LeaveRequest;
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
        $companyId = auth()->user()->company_id;
        $types = LeaveType::where('company_id', $companyId)->get();

        // Calculer l'utilisation pour chaque type (demandes approuvées cette année)
        $year = now()->year;
        foreach ($types as $type) {
            $usedDays = LeaveRequest::where('leave_type_id', $type->id)
                        ->where('status', 'approved')
                        ->whereYear('start_date', $year)
                        ->get()
                        ->sum(function ($lr) {
                            return $lr->start_date->diffInDays($lr->end_date) + 1;
                        });
            $type->used_days = $usedDays;
            $type->percentage = $type->days_allowed > 0 ? round(($usedDays / $type->days_allowed) * 100) : 0;
        }

        // KPI
        $totalTypes = $types->count();
        $totalDaysConfigured = $types->sum('days_allowed');
        $paidCount = $types->where('paid', true)->count();
        $unpaidCount = $types->where('paid', false)->count();
        $upcomingHolidays = $this->getUpcomingHolidays();

        return view('admin.leave-types.index', compact(
            'types',
            'totalTypes',
            'totalDaysConfigured',
            'paidCount',
            'unpaidCount',
            'upcomingHolidays'
        ));

        // return view('admin.leave-types.index', compact(
        //     'types',
        //     'totalTypes',
        //     'totalDaysConfigured',
        //     'paidCount',
        //     'unpaidCount'
        // ));
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

    /**
 * Retourne les deux prochains jours fériés du pays.
 */
private function getUpcomingHolidays(): array
{
    // Jours fériés fixes (mois, jour, nom)
    $fixed = [
        ['month' => 1,  'day' => 1,   'name' => 'Jour de l\'An'],
        ['month' => 5,  'day' => 1,   'name' => 'Fête du Travail'],
        ['month' => 8,  'day' => 1,   'name' => 'Fête Nationale'],
        ['month' => 8,  'day' => 15,  'name' => 'Assomption'],
        ['month' => 11, 'day' => 1,   'name' => 'Toussaint'],
        ['month' => 12, 'day' => 25,  'name' => 'Noël'],
    ];

    $holidays = [];
    $year = now()->year;
    foreach ($fixed as $h) {
        $date = \Carbon\Carbon::createFromDate($year, $h['month'], $h['day'])->startOfDay();
        if ($date->isPast()) {
            $date->addYear();
        }
        $holidays[] = ['date' => $date, 'name' => $h['name']];
    }

    // Trier par date et prendre les 2 premiers
    usort($holidays, fn($a, $b) => $a['date']->timestamp <=> $b['date']->timestamp);
    return array_slice($holidays, 0, 2);
}
}