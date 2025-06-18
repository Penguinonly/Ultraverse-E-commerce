<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import ini
use Illuminate\Database\Eloquent\Relations\HasOne;    // Import ini

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'transaksi_id';

    protected $fillable = [
        'properti_id',
        'pembeli_id',
        'tanggal_transaksi',
        'status_transaksi',
        'jenis_transaksi',
        'transaksi_admin',
        'total_harga'
    ];

    protected $casts = [
        'total_harga' => 'decimal:2',
        'tanggal_transaksi' => 'datetime'
    ];

    /**
     * Get the property that owns the transaction.
     */
    public function properti(): BelongsTo
    {
        return $this->belongsTo(Properti::class, 'properti_id', 'properti_id');
    }

    /**
     * Get the buyer (user) that owns the transaction.
     */
    public function pembeli(): BelongsTo
    {
        // Jika pembeli_id di tabel 'transaksi' mengacu ke user_id pembeli di tabel 'users'
        return $this->belongsTo(User::class, 'pembeli_id', 'user_id');
    }

    /**
     * Get the payment associated with the transaction.
     */
    public function pembayaran(): HasOne
    {
        // Jika satu transaksi memiliki satu pembayaran
        return $this->hasOne(Pembayaran::class, 'transaksi_id', 'transaksi_id');
    }
}