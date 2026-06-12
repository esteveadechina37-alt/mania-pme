<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Employee;
use Carbon\Carbon;

class ActivateEmployees extends Command
{
    protected $signature = 'employees:activate';
    protected $description = 'Active les employés dont la date d\'embauche est arrivée';

    public function handle()
    {
        $today = Carbon::today();
        $employees = Employee::where('status', 'inactive')
                    ->whereNotNull('hire_date')
                    ->where('hire_date', '<=', $today)
                    ->get();

        foreach ($employees as $employee) {
            $employee->update(['status' => 'active']);
            if ($employee->user) {
                $employee->user->update(['is_active' => true]);
            }
        }

        $this->info(count($employees) . ' employé(s) activé(s).');
    }
}