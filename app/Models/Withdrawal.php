<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'bank_name',
        'account_number',
        'account_holder',
        'status',
        'processed_at'
    ];

    protected $dates = [
        'processed_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
