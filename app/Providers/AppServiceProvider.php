<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use App\Listeners\LogSuccessfulLogin;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 1. Locale en français pour Carbon
        Carbon::setLocale('fr');

        // 2. Enregistrement de l'écouteur de connexion réussie
        Event::listen(
            Login::class,
            LogSuccessfulLogin::class
        );
    }
}