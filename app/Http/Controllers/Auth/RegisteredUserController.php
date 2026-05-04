<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        // Validation des données personnelles + entreprise
        $request->validate([
            // Infos personnelles
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'              => ['required', 'confirmed', Rules\Password::defaults()],
            // Infos entreprise
            'company_name'          => ['required', 'string', 'max:255'],
            'company_email'         => ['required', 'email', 'unique:companies,email'],
            'company_phone'         => ['nullable', 'string', 'max:20'],
            'company_sector'        => ['required', 'string', 'max:255'],
            'company_city'          => ['nullable', 'string', 'max:255'],
            'company_country'       => ['nullable', 'string', 'max:255'],
            'company_address'       => ['nullable', 'string', 'max:500'],
        ]);

        // 1. Créer l'entreprise
        $company = Company::create([
            'name'      => $request->company_name,
            'email'     => $request->company_email,
            'phone'     => $request->company_phone,
            'sector'    => $request->company_sector,
            'city'      => $request->company_city,
            'country'   => $request->company_country,
            'address'   => $request->company_address,
        ]);

        // 2. Créer l'administrateur lié à cette entreprise
        $user = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'company_id'    => $company->id,
            'is_admin'      => true,
        ]);

        // 3. Assigner le rôle admin
        $user->assignRole('admin');

        event(new Registered($user));

        Auth::login($user);

        // 4. Rediriger vers le dashboard admin
        return redirect()->route('admin.dashboard');
    }
}