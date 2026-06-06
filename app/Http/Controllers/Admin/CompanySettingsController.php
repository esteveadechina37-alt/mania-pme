<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanySettingsController extends Controller
{
    public function edit()
    {
        $company = auth()->user()->company;
        return view('admin.settings.edit', compact('company'));
    }

    public function update(Request $request)
    {
        $company = auth()->user()->company;

        $request->validate([
            'latitude'        => 'required|numeric',
            'longitude'       => 'required|numeric',
            'geofence_radius' => 'required|integer|min:50|max:5000',
        ]);

        $company->update([
            'latitude'        => $request->latitude,
            'longitude'       => $request->longitude,
            'geofence_radius' => $request->geofence_radius,
        ]);

        return back()->with('success', 'Paramètres de géolocalisation mis à jour.');
    }
}