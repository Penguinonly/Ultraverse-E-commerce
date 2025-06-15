<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Withdrawal;

class WithdrawalRequested
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $withdrawal;

    public function __construct(Withdrawal $withdrawal)
    {
        $this->withdrawal = $withdrawal;
    }
}
