<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Properti extends Model
{
    use HasFactory;

    protected $table = 'properti';
    protected $primaryKey = 'properti_id';

    protected $fillable = [
        'user_id',
        'nama_properti',
        'deskripsi',
        'lokasi',
        'harga',
        'status',
        'tipe_properti'
    ];

    protected $casts = [
        'harga' => 'decimal:2'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function gambar(): HasMany
    {
        return $this->hasMany(GambarProperti::class, 'properti_id', 'properti_id');
    }

    public function dokumen(): HasMany
    {
        return $this->hasMany(Dokumen::class, 'properti_id', 'properti_id');
    }

    public function favorit(): HasMany
    {
        return $this->hasMany(Favorit::class, 'properti_id', 'properti_id');
    }

    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'properti_id', 'properti_id');
    }

    public function laporanInspeksi(): HasMany
    {
        return $this->hasMany(LaporanInspeksi::class, 'properti_id', 'properti_id');
    }

    public function ratingUlasan(): HasMany
    {
        return $this->hasMany(RatingUlasan::class, 'properti_id', 'properti_id');
    }
}
