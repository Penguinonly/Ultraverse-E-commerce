<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GambarProperti extends Model
{
    use HasFactory;

    protected $table = 'gambar_properti';
    protected $primaryKey = 'gambar_id';    protected $fillable = [
        'properti_id',
        'url_gambar',
        'tanggal_upload'
    ];

    protected $casts = [
        'tanggal_upload' => 'datetime'
    ];

    public function properti()
    {
        return $this->belongsTo(Properti::class, 'properti_id');
    }
}
