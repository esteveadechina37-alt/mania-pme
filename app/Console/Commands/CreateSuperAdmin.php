<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateSuperAdmin extends Command
{
    protected $signature = 'create:super-admin';
    protected $description = 'Crée un compte super‑admin pour la plateforme';

    public function handle()
    {
        $name  = $this->ask('Nom du super‑admin ?', 'Super Admin');
        $email = $this->ask('Adresse email ?', 'superadmin@mania-pme.com');
        $password = $this->secret('Mot de passe ? (minimum 8 caractères)');

        if (strlen($password) < 8) {
            $this->error('Le mot de passe doit contenir au moins 8 caractères.');
            return 1;
        }

        // Vérifier si l'email existe déjà
        if (User::where('email', $email)->exists()) {
            $this->error("Un utilisateur avec l'email {$email} existe déjà.");
            return 1;
        }

        // Créer l'utilisateur (sans company_id car le super-admin est au‑dessus des entreprises)
        $user = User::create([
            'name'      => $name,
            'email'     => $email,
            'password'  => Hash::make($password),
            'is_active' => true,
        ]);

        // Assigner le rôle super-admin (assurez-vous que le rôle existe)
        $user->assignRole('super-admin');

        $this->info('✅ Compte super‑admin créé avec succès !');
        $this->info("Email    : {$email}");
        $this->info("Mot de passe : (celui que vous avez saisi)");
    }
}