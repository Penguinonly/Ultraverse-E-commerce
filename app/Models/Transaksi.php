<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'transaksi_id';    protected $fillable = [
        'properti_id',
        'pembeli_id',
        'penjual_id',
        'total_harga',
        'status_transaksi'
    ];

    protected $casts = [
        'total_harga' => 'decimal:2'
    ];

    public function properti()
    {
        return $this->belongsTo(Properti::class, 'properti_id');
    }

    public function pembeli()
    {        return $this->belongsTo(User::class, 'pembeli_id', 'user_id');
    }

    public function penjual()
    {
        return $this->belongsTo(User::class, 'penjual_id', 'user_id');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'transaksi_id');
    }
}
