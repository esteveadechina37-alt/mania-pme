<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;

class CompanySubscriptionController extends Controller
{
    public function index()
    {
        $company = auth()->user()->company;
        $currentSubscription = $company->subscription()->with('plan')->first();
        $plans = Plan::where('is_active', true)->with('modules')->get();

        return view('admin.subscription.index', compact('currentSubscription', 'plans'));
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
        ]);

        $plan = Plan::findOrFail($request->plan_id);
        $company = auth()->user()->company;

        // Mettre à jour ou créer l'abonnement
        $subscription = $company->subscription()->first();
        if ($subscription) {
            $subscription->update([
                'plan_id'   => $plan->id,
                'status'    => 'active',
                'starts_at' => now(),
                'ends_at'   => null,
            ]);
        } else {
            $company->subscription()->create([
                'plan_id'   => $plan->id,
                'status'    => 'active',
                'starts_at' => now(),
            ]);
        }

        return redirect()->route('admin.company.subscription')
            ->with('success', "Vous êtes maintenant abonné au plan « {$plan->name} ».");
    }
}