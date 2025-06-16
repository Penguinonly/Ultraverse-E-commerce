<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    public $timestamps = true;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'password',
        'noktp',
        'nama',
        'email',
        'no_telepon',
        'alamat',
        'foto_ktp',
        'verivikasi_wajah',
        'pendapatan_perbulan',
        'id_peran'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'pendapatan_perbulan' => 'integer',
        'verivikasi_wajah' => 'boolean'
    ];

    /**
     * Get the user's role.
     */
    public function peran()
    {
        return $this->belongsTo(Peran::class, 'id_peran', 'id_peran');
    }

    /**
     * Check if user has specific role
     */
    public function hasRole(string $role): bool
    {
        $userRole = $this->peran()->first();
        return $userRole ? strtolower($userRole->nama_peran) === strtolower($role) : false;
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function properti()
    {
        return $this->hasMany(Properti::class, 'user_id');
    }

    public function favorit()
    {
        return $this->hasMany(Favorit::class, 'user_id');
    }

    public function transaksiAsPembeli()
    {
        return $this->hasMany(Transaksi::class, 'pembeli_id');
    }

    public function transaksiAsPenjual()
    {
        return $this->hasMany(Transaksi::class, 'penjual_id');
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'user_id');
    }

    public function pesanDikirim()
    {
        return $this->hasMany(Pesan::class, 'pengirim_id');
    }

    public function pesanDiterima()
    {
        return $this->hasMany(Pesan::class, 'penerima_id');
    }

    public function laporanInspeksi()
    {
        return $this->hasMany(LaporanInspeksi::class, 'inspector_id');
    }

    public function ratingUlasan()
    {
        return $this->hasMany(RatingUlasan::class, 'user_id');
    }

    public function dokumen()
    {
        return $this->hasMany(Dokumen::class, 'user_id', 'user_id');
    }
}
