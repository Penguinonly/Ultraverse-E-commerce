<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'pembayaran_id';
    public $timestamps = false;

    protected $fillable = [
        'transaksi_id',
        'metode_pembayaran',
        'jumlah',
        'tanggal',
        'status_pembayaran',
        'bukti_pembayaran',
        'tanggal_pembayaran',
        'konfirmasi_pembayaran'
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'tanggal' => 'datetime',
        'tanggal_pembayaran' => 'datetime',
        'konfirmasi_pembayaran' => 'boolean'
    ];

    /**
     * Get the transaksi that owns the pembayaran
     */
    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id', 'transaksi_id');
    }

    /**
     * Scope a query to only include pending payments
     */
    public function scopePending($query)
    {
        return $query->where('status_pembayaran', 'pending')
                    ->whereNull('konfirmasi_pembayaran');
    }

    /**
     * Scope a query to only include active payments
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status_pembayaran', ['pending', 'proses']);
    }
}
