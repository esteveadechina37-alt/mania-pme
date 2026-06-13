<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;

class ModuleSeeder extends Seeder
{
    public function run()
    {
        $modules = [
            ['name' => 'Gestion des employés',    'key' => 'employees',        'description' => 'CRUD employés, fiches détaillées.', 'is_free' => true],
            ['name' => 'Départements',            'key' => 'departments',      'description' => 'Gestion des départements.',           'is_free' => true],
            ['name' => 'Types de congés',         'key' => 'leave_types',      'description' => 'Configuration des types de congés.',  'is_free' => true],
            ['name' => 'Congés',                  'key' => 'leaves',           'description' => 'Demandes, validation, historique.',   'is_free' => true],
            ['name' => 'Présences',               'key' => 'attendances',      'description' => 'Pointages, liste, exports.',          'is_free' => true],
            ['name' => 'Paie',                    'key' => 'payslips',         'description' => 'Génération de bulletins de paie.',   'is_free' => true],
            ['name' => 'Documents RH',            'key' => 'documents',        'description' => 'Upload et attestations.',             'is_free' => true],
            ['name' => 'Évaluations',             'key' => 'evaluations',      'description' => 'Suivi des performances.',            'is_free' => true],
            ['name' => 'Contrats',                'key' => 'contracts',        'description' => 'Gestion des contrats de travail.',   'is_free' => true],
            ['name' => 'Programme hebdomadaire',  'key' => 'weekly_program',   'description' => 'Objectifs de la semaine.',            'is_free' => true],
            ['name' => 'Rapports avancés',        'key' => 'advanced_reports', 'description' => 'KPIs avancés, exports Excel.',       'is_free' => false],
            ['name' => 'Export Excel',            'key' => 'export_excel',     'description' => 'Exports complets en Excel.',          'is_free' => false],
            ['name' => 'Gestion multi-sites',     'key' => 'multi_site',       'description' => 'Plusieurs sites par entreprise.',     'is_free' => false],
        ];

        foreach ($modules as $mod) {
            Module::create($mod);
        }
    }
}