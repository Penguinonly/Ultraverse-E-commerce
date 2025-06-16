<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notifikasi extends Model
{
    use HasFactory;
    protected $table = 'notifikasi';
    protected $primaryKey = 'notifikasi_id';

    protected $fillable = [
        'user_id',
        'judul',
        'pesan',
        'dibaca',
        'tanggal'
    ];

    protected $casts = [
        'dibaca' => 'boolean',
        'tanggal' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
