<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pesan extends Model
{
    use HasFactory;

    protected $table = 'pesan';

    // ✅ Hanya gunakan $primaryKey jika kolom utama TIDAK bernama 'id'
    // Jika di tabel kamu primary key tetap 'id', HAPUS baris ini:
    // protected $primaryKey = 'pesan_id';

    public $timestamps = false; // ✅ Gunakan false karena kamu pakai kolom 'timestamp' sendiri

    protected $fillable = [
        'pengirim_id',
        'penerima_id',
        'isi_pesan',
        'dibaca',
        'timestamp',
    ];

    protected $casts = [
        'dibaca' => 'boolean',
        'timestamp' => 'datetime',
    ];

    // ✅ Relasi ke User (pengirim)
    public function pengirim(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengirim_id', 'id');
    }

    // ✅ Relasi ke User (penerima)
    public function penerima(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penerima_id', 'id');
    }
}
