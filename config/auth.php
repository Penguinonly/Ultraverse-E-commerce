<?php

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        // Tambahkan guard 'admin' di sini
        'admin' => [
            'driver' => 'session',
            'provider' => 'users', // Admin juga akan menggunakan provider 'users'
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
            // Baris 'custom_id_column' ini sebenarnya tidak diperlukan di config/auth.php
            // karena Laravel secara otomatis akan menemukan primary key berdasarkan $primaryKey
            // yang didefinisikan di model User.
            // Anda sudah benar mendefinisikan 'user_id' sebagai primary key di model User Anda.
            // Jadi, baris ini bisa dipertahankan sebagai catatan, atau dihapus jika dirasa berlebihan.
            // Saya akan biarkan, tapi perlu diingat bahwa ini bukan konfigurasi standar Laravel Auth.
            // Laravel akan mencari properti $primaryKey di Model itu sendiri.
            'custom_id_column' => 'user_id',
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens', // Perbaiki dari 'password_resets' ke 'password_reset_tokens'
                                                 // sesuai dengan nama tabel migrasi default Laravel
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];