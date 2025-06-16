<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanInspeksi extends Model
{
    protected $table = 'laporan_inspeksi';
    protected $primaryKey = 'laporan_id';

    protected $fillable = [
        'properti_id',
        'inspector_id',
        'hasil_inspeksi',
        'status_laporan'
    ];

    public function properti(): BelongsTo
    {
        return $this->belongsTo(Properti::class, 'properti_id', 'properti_id');
    }

    public function inspector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inspector_id', 'user_id');
    }
}
