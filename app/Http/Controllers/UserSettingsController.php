<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSettingsController extends Controller
{
    public function edit()
    {
        $user = User::find(Auth::id());
        return view('user-settings.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = User::find(Auth::id());

        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:users,email,' . $user->id,
            'current_password' => 'required_with:password|nullable',
            'password'         => 'nullable|string|min:8|confirmed',
        ], [
            'name.required'             => 'Le nom est obligatoire.',
            'name.max'                  => 'Le nom ne peut pas dépasser 255 caractères.',
            'email.required'            => 'L\'email est obligatoire.',
            'email.email'               => 'L\'adresse email n\'est pas valide.',
            'email.unique'              => 'Cette adresse email est déjà utilisée.',
            'current_password.required_with' => 'Le mot de passe actuel est requis pour changer le mot de passe.',
            'password.min'              => 'Le nouveau mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed'        => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        // ✅ Vérifier le mot de passe actuel AVANT toute modification
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()
                    ->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.'])
                    ->withInput();
            }
            $user->password = Hash::make($request->password);
        }

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'Vos paramètres ont été mis à jour avec succès.');
    }
}