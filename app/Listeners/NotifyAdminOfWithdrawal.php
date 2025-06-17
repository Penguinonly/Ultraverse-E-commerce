<?php

namespace App\Listeners;

use App\Events\WithdrawalRequested;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AdminWithdrawalNotification;

class NotifyAdminOfWithdrawal implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(WithdrawalRequested $event): void
    {
        // Log untuk verifikasi (opsional)
        Log::info('WithdrawalRequested event captured', [
            'user_id' => $event->withdrawal->user_id,
            'amount' => $event->withdrawal->amount,
        ]);

        // Kirim notifikasi ke admin (misal user dengan role admin)
        $admins = \App\Models\User::where('role', 'admin')->get();

        Notification::send($admins, new AdminWithdrawalNotification($event->withdrawal));
    }
}
