<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $company = auth()->user()->company;

        // Pour l'instant, pas de notion d'équipe → membres de l'entreprise ayant le rôle employé (ou stagiaire)
        $teamMembersCount = \App\Models\User::where('company_id', $company->id)
            ->whereHas('roles', fn($q) => $q->whereIn('name', ['employe', 'stagiaire']))
            ->count();

        // Demandes de congé en attente → 0 pour le moment
        $pendingRequests = 0;

        // Présences aujourd'hui → 0
        $presentToday = 0;

        // Dernières demandes (vide)
        $recentRequests = [];

        return view('manager.dashboard', compact(
            'teamMembersCount',
            'pendingRequests',
            'presentToday',
            'recentRequests'
        ));
    }
}