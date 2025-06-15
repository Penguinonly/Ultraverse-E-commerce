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
      protected $primaryKey = 'user_id';
    
    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
        'no_telepon',
        'alamat',
        'noktp',
        'foto_ktp',
        'verifikasi_wajah',
        'pendapatan_perbulan'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'noktp',
        'foto_ktp',
        'verifikasi_wajah'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_verified' => 'boolean',
        'pendapatan_perbulan' => 'decimal:2'
    ];

    /**
     * Get the properties listed by this user (for sellers)
     */
    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    /**
     * Get the saved properties for this user (for buyers)
     */
    public function savedProperties()
    {
        return $this->hasMany(SavedProperty::class);
    }

    /**
     * Get user's documents
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Get user's payments as buyer
     */
    public function buyerPayments()
    {
        return $this->hasMany(Payment::class, 'buyer_id');
    }

    /**
     * Get user's payments as seller
     */
    public function sellerPayments()
    {
        return $this->hasMany(Payment::class, 'seller_id');
    }

    /**
     * Get user's settings
     */
    public function settings()
    {
        return $this->hasOne(UserSetting::class);
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is seller
     */
    public function isPenjual()
    {
        return $this->role === 'penjual';
    }

    /**
     * Check if user is buyer
     */
    public function isPembeli()
    {
        return $this->role === 'pembeli';
    }

    /**
     * Get the user's session
     */
    public function session()
    {
        return $this->hasOne(Session::class);
    }
}
