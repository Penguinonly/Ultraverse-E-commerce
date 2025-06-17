<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory;

    protected $table = 'dokumen';
    protected $primaryKey = 'dokumen_id';
    public $timestamps = true;

    protected $fillable = [
        'properti_id',
        'user_id',
        'nama_dokumen',
        'file_path',
        'status',
        'tanggal_upload',
        'filename',
        'type',
        'description',
        'mime_type',
        'size'
    ];

    protected $casts = [
        'tanggal_upload' => 'datetime',
    ];

    public function properti()
    {
        return $this->belongsTo(Properti::class, 'properti_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function fileExists(): bool
    {
        return Storage::disk('private')->exists($this->file_path);
    }

    public function downloadUrl(): string
    {
        return route('documents.download', $this->dokumen_id);
    }
}
