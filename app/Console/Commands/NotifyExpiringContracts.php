<?php

namespace App\Console\Commands;

use App\Models\Employee;
use App\Models\Notification;
use App\Mail\RhNotificationMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class NotifyExpiringContracts extends Command
{
    protected $signature = 'contracts:notify-expiring';
    protected $description = 'Notify admins of contracts expiring in 30 days';

    public function handle()
    {
        $in30Days = now()->addDays(30)->toDateString();
        $employees = Employee::whereNotNull('contract_end_date')
            ->whereDate('contract_end_date', $in30Days)
            ->where('status', 'active')
            ->whereNull('deleted_at')
            ->with('user', 'company')
            ->get();

        foreach ($employees as $emp) {
            $admins = \App\Models\User::where('company_id', $emp->company_id)
                ->whereHas('roles', fn($q) => $q->where('name', 'admin'))
                ->get();

            $title = 'Contrat expirant bientôt';
            $message = "Le contrat de {$emp->user->name} (type : {$emp->contract_type}) expire le " . \Carbon\Carbon::parse($emp->contract_end_date)->format('d/m/Y') . ".";

            foreach ($admins as $admin) {
                // Éviter les doublons
                $alreadyNotified = Notification::where('user_id', $admin->id)
                    ->where('company_id', $emp->company_id)
                    ->where('type', 'contract_expiring')
                    ->where('created_at', '>=', now()->subDays(1))
                    ->exists();

                if (!$alreadyNotified) {
                    Notification::create([
                        'user_id'    => $admin->id,
                        'company_id' => $emp->company_id,
                        'type'       => 'contract_expiring',
                        'title'      => $title,
                        'message'    => $message,
                    ]);
                    try {
                        Mail::to($admin->email)->send(new RhNotificationMail($title, $message, $admin->name));
                    } catch (\Exception $e) {
                        \Log::error("Erreur envoi mail contrat : " . $e->getMessage());
                    }
                }
            }
        }

        $this->info('Notifications de contrats expirants envoyées.');
    }
}