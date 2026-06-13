<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Company;
use App\Models\Plan;

return new class extends Migration
{
    public function up(): void
    {
        $freePlan = Plan::where('slug', 'gratuit')->first();
        if ($freePlan) {
            Company::each(function ($company) use ($freePlan) {
                $company->subscription()->create([
                    'plan_id'   => $freePlan->id,
                    'status'    => 'active',
                    'starts_at' => now(),
                ]);
            });
        }
    }

    public function down(): void
    {
        // aucune action
    }
};