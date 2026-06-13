<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Module;
use App\Models\Subscription;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    // Afficher la liste des plans
    public function plans()
    {
        $plans = Plan::with('modules')->get();
        return view('super-admin.plans.index', compact('plans'));
    }

    // Formulaire de création d'un plan
    public function createPlan()
    {
        $modules = Module::all();
        return view('super-admin.plans.create', compact('modules'));
    }

    // Enregistrer un nouveau plan
    public function storePlan(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'slug'           => 'required|string|unique:plans,slug',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'billing_period' => 'required|in:monthly,yearly',
            'modules'        => 'nullable|array',
            'modules.*'      => 'exists:modules,id',
        ]);

        $plan = Plan::create([
            'name'           => $data['name'],
            'slug'           => $data['slug'],
            'description'    => $data['description'] ?? null,
            'price'          => $data['price'],
            'billing_period' => $data['billing_period'],
            'is_active'      => true,
            'is_free'        => false,
        ]);

        if (isset($data['modules'])) {
            // $plan->modules()->sync($data['modules']);
            $plan->modules()->sync(
            Module::where('is_free', true)->pluck('id')
            ->merge($request->input('modules', []))
        );
        }

        $admins = User::role('admin')->whereNotNull('company_id')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id'    => $admin->id,
                'company_id' => $admin->company_id,
                'type'       => 'new_plan',
                'title'      => 'Nouveau plan disponible',
                'message'    => "Le plan « {$plan->name} » est désormais disponible. Consultez la page abonnement.",
            ]);
        }

        return redirect()->route('super-admin.plans.index')->with('success', 'Plan créé avec succès.');
    }

    // Formulaire d'édition d'un plan
    public function editPlan(Plan $plan)
    {
        $modules = Module::all();
        return view('super-admin.plans.edit', compact('plan', 'modules'));
    }

    // Mettre à jour un plan
    public function updatePlan(Request $request, Plan $plan)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'slug'           => 'required|string|unique:plans,slug,' . $plan->id,
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'billing_period' => 'required|in:monthly,yearly',
            'modules'        => 'nullable|array',
            'modules.*'      => 'exists:modules,id',
        ]);

        $plan->update([
            'name'           => $data['name'],
            'slug'           => $data['slug'],
            'description'    => $data['description'] ?? null,
            'price'          => $data['price'],
            'billing_period' => $data['billing_period'],
        ]);

        if (isset($data['modules'])) {
            // $plan->modules()->sync($data['modules']);
                        $plan->modules()->sync(
                Module::where('is_free', true)->pluck('id')
                ->merge($request->input('modules', []))
            );
        } else {
            $plan->modules()->detach();
        }

        return redirect()->route('super-admin.plans.index')->with('success', 'Plan mis à jour.');
    }

    // Afficher la liste des abonnements
    public function subscriptions(Request $request)
    {
        $subscriptions = Subscription::with(['company', 'plan'])
                            ->latest()
                            ->paginate(20);
        return view('super-admin.subscriptions.index', compact('subscriptions'));
    }

    // Annuler un abonnement
    public function cancel(Subscription $subscription)
    {
        // 1. Annuler l'abonnement
        $subscription->update(['status' => 'cancelled', 'ends_at' => now()]);

        // 2. Désactiver tous les utilisateurs de l'entreprise
        $company = $subscription->company;
        if ($company) {
            $company->users()->update(['is_active' => false]);
        }

        return back()->with('success', 'Abonnement annulé. L\'entreprise et ses utilisateurs ont été désactivés.');
    }
    // public function cancel(Subscription $subscription)
    // {
    //     $subscription->update(['status' => 'cancelled', 'ends_at' => now()]);
    //     return back()->with('success', 'Abonnement annulé.');
    // }
}