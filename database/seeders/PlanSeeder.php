<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;
use App\Models\Module;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $freePlan = Plan::firstOrCreate(
            ['slug' => 'gratuit'],
            [
                'name'           => 'Gratuit',
                'description'    => 'Tous les modules de base inclus.',
                'price'          => 0,
                'billing_period' => null,
                'is_active'      => true,
                'is_free'        => true,
            ]
        );

        // Associer tous les modules gratuits au plan gratuit
        $freeModules = Module::where('is_free', true)->pluck('id');
        $freePlan->modules()->sync($freeModules);
    }
}