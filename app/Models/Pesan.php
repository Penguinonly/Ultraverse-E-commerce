<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pesan extends Model
{
    use HasFactory;
    
    protected $table = 'pesan';
    public $timestamps = true;
    protected $primaryKey = 'pesan_id';

    protected $fillable = [
        'pengirim_id',
        'penerima_id',
        'isi_pesan',
        'dibaca',
        'timestamp'
    ];

    protected $casts = [
        'dibaca' => 'boolean',
        'timestamp' => 'datetime'
    ];

    public function pengirim(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengirim_id', 'user_id');
    }

    public function penerima(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penerima_id', 'user_id');
    }
}
