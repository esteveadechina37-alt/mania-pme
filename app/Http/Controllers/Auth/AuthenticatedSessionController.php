<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = auth()->user();

          // ⭐ Réactiver l'employé si sa date d'embauche est passée
        $employee = Employee::where('user_id', $user->id)->first();
        if ($employee && $employee->status === 'inactive' && $employee->hire_date) {
            $hireDate = \Carbon\Carbon::parse($employee->hire_date)->startOfDay();
            if (now()->startOfDay()->gte($hireDate)) {
                $employee->update(['status' => 'active']);
                $user->update(['is_active' => true]);
                // Recharger l'utilisateur pour refléter le changement
                $user->refresh();
            }
        }

         // ⭐ Signaler si le changement de mot de passe est obligatoire
            if ($user->must_change_password) {
                session()->flash('show_password_modal', true);
            }


         if (!$user->is_active) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->withErrors([
            'email' => 'Votre compte a été désactivé.',
        ]);
    }
        if ($user->hasRole('super-admin')) {
            return redirect()->route('super-admin.dashboard');
        } elseif ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('manager')) {
            return redirect()->route('manager.dashboard');
        } else {
            return redirect()->route('employee.dashboard');
        }
        // if ($user->hasRole('super-admin') || $user->hasRole('admin')) {
        //     return redirect()->route('admin.dashboard');
        // } elseif ($user->hasRole('manager')) {
        //     return redirect()->route('manager.dashboard');
        // } else {
        //     return redirect()->route('employee.dashboard');
        // }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
