<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertyImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'filename',
        'path',
        'is_primary',
        'tanggal_upload'
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'tanggal_upload' => 'datetime'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
