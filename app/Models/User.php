<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use \Illuminate\Database\Eloquent\Concerns\HasAttributes;

    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'avatar'
    ];

    // Role checking methods
    public function isAdmin() {
        return $this->role === 'admin';
    }

    public function isPenjual() {
        return $this->role === 'penjual';
    }

    public function isPembeli() {
        return $this->role === 'pembeli';
    }
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function savedProperties()
    {
        return $this->belongsToMany(Property::class, 'saved_properties')
                    ->withTimestamps();
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function settings()
    {
        return $this->hasOne(UserSetting::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'seller_id');
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }
}
