<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorit extends Model
{
    use HasFactory;

    protected $table = 'favorit';

    protected $fillable = [
        'user_id',
        'properti_id',
        'tanggal_disimpan'
    ];

    protected $dates = [
        'tanggal_disimpan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function properti()
    {
        return $this->belongsTo(Properti::class, 'properti_id');
    }
}
