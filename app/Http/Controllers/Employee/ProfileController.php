<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    private function getEmployee(): Employee
    {
        $user = Auth::user();
        $employee = Employee::where('user_id', $user->id)
                    ->withTrashed()
                    ->first();

        if ($employee) {
            if ($employee->trashed()) {
                $employee->restore();
            }
            $employee->update([
                'status'    => $employee->status ?: 'active',
                'hire_date' => $employee->hire_date ?: now(),
            ]);
            return $employee;
        }

        return Employee::create([
            'user_id'    => $user->id,
            'company_id' => $user->company_id,
            'status'     => 'active',
            'hire_date'  => now(),
        ]);
    }

    public function index()
    {
        $user = Auth::user();
        $employee = $this->getEmployee();

        return view('employee.profile', compact('user', 'employee'));
    }

    // public function updateAvatar(Request $request)
    // {
    //     $request->validate([
    //         'avatar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    //     ]);

    //     $user = Auth::user();

    //     // Supprimer l'ancien avatar s'il existe
    //     if ($user->avatar && \Storage::exists($user->avatar)) {
    //         \Storage::delete($user->avatar);
    //     }

    //     // Enregistrer le nouveau fichier
    //     $path = $request->file('avatar')->store('avatars/' . $user->company_id, 'public');

    //     // Mettre à jour l'utilisateur
    //     $user->update(['avatar' => $path]);

    //     return back()->with('success', 'Photo de profil mise à jour.');
    // }
}