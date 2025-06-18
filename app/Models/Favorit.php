<?php

namespace App\Models; // Namespace yang benar untuk model

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import BelongsTo untuk type hinting

class Favorit extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'favorit'; // Pastikan nama tabelnya 'favorit' sesuai database Anda

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'favorit_id'; // Asumsi primary key Anda di tabel favorit adalah 'favorit_id'. Sesuaikan jika berbeda.

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'properti_id',
        'tanggal_disimpan',
    ];

    /**
     * The attributes that should be cast to native types.
     * Menggunakan $casts lebih disarankan daripada $dates di Laravel versi baru.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_disimpan' => 'datetime', // Menggunakan 'datetime' untuk casting otomatis
    ];

    /**
     * Get the user that owns the favorite.
     */
    public function user(): BelongsTo
    {
        // Mendefinisikan relasi Many-to-One ke model User.
        // 'user_id' adalah foreign key di tabel 'favorit'.
        // 'user_id' adalah local key (primary key) di tabel 'users'.
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Get the property that is favorited.
     */
    public function properti(): BelongsTo
    {
        // Mendefinisikan relasi Many-to-One ke model Properti.
        // 'properti_id' adalah foreign key di tabel 'favorit'.
        // 'properti_id' adalah local key (primary key) di tabel 'properti'.
        return $this->belongsTo(Properti::class, 'properti_id', 'properti_id');
    }
}