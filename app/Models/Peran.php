<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Peran extends Model
{
    protected $table = 'peran';
    protected $primaryKey = 'id_peran';
    
    protected $fillable = [
        'nama_peran',
        'deskripsi'
    ];

    /**
     * Get users with this role
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'id_peran', 'id_peran');
    }
}
