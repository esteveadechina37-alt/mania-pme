<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Congés restants → simulation (plus tard on récupérera depuis la table leave_requests)
        $congesRestants = 25; // jours

        // Dernière fiche de paie → pas encore de table, date fictive
        $derniereFicheDate = 'Avril 2026';

        // Heures pointées (semaine) → 0
        $heuresPointees = 0;

        // Dernières demandes de congé (vide)
        $demandesRecentes = [];

        return view('employee.dashboard', compact(
            'congesRestants',
            'derniereFicheDate',
            'heuresPointees',
            'demandesRecentes'
        ));
    }
}