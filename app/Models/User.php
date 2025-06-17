<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'noktp',
        'nama',
        'email',
        'password',
        'no_telepon',
        'nama_toko',
        'alamat',
        'foto_ktp',
        'verifikasi_wajah',
        'pendapatan_perbulan',
        'role',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'no_telepon' => 'integer',
        'nama_toko' => 'string'
    ];

    /**
     * Default values for attributes
     *
     * @var array
     */
    protected $attributes = [
        'is_active' => false
    ];

    /**
     * Automatically hash the password when it's being set
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    /**
     * Check if user is active
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }

    /**
     * Get the user's properties (for sellers)
     */
    public function properties()
    {
        return $this->hasMany(Properti::class, 'user_id');
    }

    /**
     * Get the user's saved properties (for buyers)
     */
    public function savedProperties()
    {
        return $this->hasMany(SavedProperty::class, 'user_id');
    }

    /**
     * Get the user's transactions
     */
    public function transactions()
    {
        return $this->hasMany(Transaksi::class, 'user_id');
    }

    /**
     * Get the user's notifications
     */
    public function notifications()
    {
        return $this->hasMany(Notifikasi::class, 'user_id');
    }
}
