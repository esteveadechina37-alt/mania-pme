<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Department;
use App\Models\Employee;

class SyncManagerDepartment extends Command
{
    // Signature : le nom que tu taperas après "php artisan"
    protected $signature = 'sync:manager-department';

    // Description qui apparaît dans la liste des commandes
    protected $description = 'Met à jour le département des managers dans la table employees pour correspondre à celui du département qu’ils gèrent';

    public function handle()
    {
        $this->info('Synchronisation des départements des managers...');

        // Récupère tous les départements où un manager est assigné
        $departments = Department::whereNotNull('manager_id')->get();

        $updated = 0;

        foreach ($departments as $department) {
            // Cherche l'employé correspondant dans la même entreprise
            $employee = Employee::where('user_id', $department->manager_id)
                         ->where('company_id', $department->company_id)
                         ->first();

            if ($employee) {
                // Si l'employé existe, on met à jour son département
                $employee->department_id = $department->id;
                $employee->save();
                $updated++;
            }
        }

        $this->info("$updated fiche(s) employé mise(s) à jour.");
    }
}