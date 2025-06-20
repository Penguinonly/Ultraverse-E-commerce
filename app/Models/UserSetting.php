<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'notification_preferences',
        'payment_methods',
        'language'
    ];

    protected $casts = [
        'notification_preferences' => 'array',
        'payment_methods' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
