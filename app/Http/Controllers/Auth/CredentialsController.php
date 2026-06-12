<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class CredentialsController extends Controller
{
    public function update(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'email'    => 'required|email|unique:users,email,' . $user->id,
        'password' => ['required', 'confirmed', Password::defaults()],
    ]);

    $user->email = $request->email;
    $user->password = bcrypt($request->password);
    $user->must_change_password = false;
    $user->save();

    return back()->with('success', 'Vos identifiants ont été mis à jour.');
}
    // public function update(Request $request)
    // {
    //     $user = Auth::user();

    //     $request->validate([
    //         'email'    => 'required|email|unique:users,email,' . $user->id,
    //         'password' => ['required', 'confirmed', Password::defaults()],
    //     ]);

    //     $user->update([
    //         'email'                => $request->email,
    //         'password'             => bcrypt($request->password),
    //         'must_change_password' => false,
    //     ]);

    //     return back()->with('success', 'Vos identifiants ont été mis à jour.');
    // }
}   