<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;

    protected $table = 'dokumen';
    protected $primaryKey = 'dokumen_id';
    public $timestamps = false;

    protected $fillable = [
        'properti_id',
        'user_id',
        'nama_dokumen',
        'file_path',
        'status',
        'tanggal_upload'
    ];

    protected $casts = [
        'tanggal_upload' => 'datetime'
    ];

    public function properti()
    {
        return $this->belongsTo(Properti::class, 'properti_id', 'properti_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
