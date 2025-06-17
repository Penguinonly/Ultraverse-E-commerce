<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Withdrawal;

class AdminWithdrawalNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $withdrawal;

    /**
     * Create a new notification instance.
     */
    public function __construct(Withdrawal $withdrawal)
    {
        $this->withdrawal = $withdrawal;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Permintaan Penarikan Baru')
            ->greeting('Halo Admin,')
            ->line('Ada permintaan penarikan baru dari user ID: ' . $this->withdrawal->user_id)
            ->line('Jumlah: Rp ' . number_format($this->withdrawal->amount, 0, ',', '.'))
            ->line('Bank: ' . $this->withdrawal->bank_name)
            ->line('No. Rekening: ' . $this->withdrawal->account_number)
            ->line('Atas Nama: ' . $this->withdrawal->account_name)
            ->action('Lihat Detail', url('/admin/withdrawals'))
            ->line('Silakan segera proses permintaan ini.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'user_id' => $this->withdrawal->user_id,
            'amount' => $this->withdrawal->amount,
            'bank_name' => $this->withdrawal->bank_name,
            'account_number' => $this->withdrawal->account_number,
            'account_name' => $this->withdrawal->account_name,
        ];
    }
}
