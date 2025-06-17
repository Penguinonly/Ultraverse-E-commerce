<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RatingUlasan extends Model
{
    protected $table = 'rating_ulasan';
    protected $primaryKey = 'ulasan_id';

    protected $fillable = [
        'user_id',
        'properti_id',
        'nilai_rating',
        'ulasan',
        'tanggal',
        'komentar'
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'rating' => 'integer'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function properti(): BelongsTo
    {
        return $this->belongsTo(Properti::class, 'properti_id', 'properti_id');
    }
}
