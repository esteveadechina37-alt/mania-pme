<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use App\Models\UserLogin;

class LogSuccessfulLogin
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle(Login $event): void
{
    $user = $event->user;
    $ip = $this->request->ip();
    $userAgent = $this->request->userAgent();
    $now = now();

    // Évite les doublons : ne pas enregistrer si déjà une entrée identique dans les 2 dernières minutes
    $existing = \App\Models\UserLogin::where('user_id', $user->id)
                    ->where('ip_address', $ip)
                    ->where('user_agent', $userAgent)
                    ->where('created_at', '>=', $now->copy()->subMinutes(2))
                    ->first();

    if (!$existing) {
        \App\Models\UserLogin::create([
            'user_id'    => $user->id,
            'ip_address' => $ip,
            'user_agent'  => $userAgent,
            'created_at'  => $now,
        ]);
    }
}
}