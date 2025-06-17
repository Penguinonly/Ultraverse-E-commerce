<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments'; // pastikan nama tabel sesuai

    protected $fillable = [
        'seller_id',
        'buyer_id',
        'property_id',
        'amount',
        'payment_method',
        'status',
        'transaction_id',
        'payment_date'
    ];

    protected $dates = [
        'payment_date'
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function property()
    {
        return $this->belongsTo(Properti::class, 'property_id'); // pastikan modelnya Properti
    }
}
