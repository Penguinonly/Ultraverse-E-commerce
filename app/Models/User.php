<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail; // Opsional: uncomment jika Anda menggunakan fitur verifikasi email
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany; // Penting: Import HasMany

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'user_id'; // Pastikan ini sesuai dengan kolom primary key di tabel 'users' Anda.

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'noktp', // Pastikan kolom ini ada di migrasi 'users' Anda
        'nama',
        'email',
        'password',
        'no_telepon',
        'nama_toko',
        'alamat',
        'foto_ktp', // Pastikan kolom ini ada di migrasi 'users' Anda
        'verifikasi_wajah', // Pastikan kolom ini ada di migrasi 'users' Anda
        'pendapatan_perbulan', // Pastikan kolom ini ada di migrasi 'users' Anda
        'role',
        'is_active',
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
        'is_active' => 'boolean', // Penting: Pastikan ini dicasting ke boolean
        // Hapus casting berikut jika tidak diperlukan atau sudah ditangani di bagian lain
        // 'no_telepon' => 'string',
        // 'pendapatan_perbulan' => 'integer',
        // 'nama_toko' => 'string',
        'password' => 'hashed', // Laravel 9+ secara otomatis meng-hash password jika disimpan melalui model dan kolom ini dicasting 'hashed'
    ];

    /**
     * Nilai default untuk kolom tertentu
     * CATATAN: Jika Anda mengatur 'is_active' ke false di sini,
     * pastikan Anda memiliki mekanisme untuk mengaktifkannya (misalnya, verifikasi admin).
     * Jika default di database adalah TRUE (1), jangan atur di sini agar konsisten.
     * Dari screenshot debug Anda, 'is_active' seringkali false, ini mungkin penyebabnya.
     */
    protected $attributes = [
        'is_active' => true, // Ubah menjadi true secara default jika user harus langsung aktif setelah register
        // Jika is_active diset di migrasi dengan DEFAULT 1, maka ini boleh dihapus atau disesuaikan
    ];


    // --- Definisi Relasi ---

    /**
     * Relasi ke properti yang dimiliki oleh user (jika user adalah 'penjual').
     * Menggunakan type hint HasMany untuk kejelasan.
     */
    public function properti(): HasMany
    {
        // Pastikan 'user_id' di tabel 'properti' merujuk ke 'user_id' di tabel 'users'.
        return $this->hasMany(Properti::class, 'user_id', 'user_id');
    }

    /**
     * Relasi ke properti yang disimpan sebagai favorit oleh user (jika user adalah 'pembeli').
     * Relasi ini yang dibutuhkan oleh `UserController::pembeliFavorit()`.
     * Menggunakan type hint HasMany untuk kejelasan.
     */
    public function favorit(): HasMany
    {
        // Asumsi tabel 'favorit' memiliki kolom 'user_id' yang merujuk ke 'user_id' di tabel 'users'.
        return $this->hasMany(Favorit::class, 'user_id', 'user_id');
    }

    /**
     * Relasi ke transaksi yang diinisiasi oleh user (jika user adalah 'pembeli').
     * Menggunakan type hint HasMany untuk kejelasan.
     */
    public function transaksiPembeli(): HasMany
    {
        // Asumsi tabel 'transaksi' memiliki kolom 'pembeli_id' yang merujuk ke 'user_id' di tabel 'users'.
        return $this->hasMany(Transaksi::class, 'pembeli_id', 'user_id');
    }

    /**
     * Relasi ke transaksi di mana user adalah penjual.
     * Menggunakan type hint HasMany untuk kejelasan.
     */
    public function transaksiPenjual(): HasMany
    {
        // Asumsi tabel 'transaksi' memiliki kolom 'penjual_id' yang merujuk ke 'user_id' di tabel 'users'.
        return $this->hasMany(Transaksi::class, 'penjual_id', 'user_id');
    }

    /**
     * Relasi ke notifikasi yang dimiliki user.
     * Menggunakan type hint HasMany untuk kejelasan.
     */
    public function notifikasi(): HasMany
    {
        // Asumsi tabel 'notifikasi' memiliki kolom 'user_id' yang merujuk ke 'user_id' di tabel 'users'.
        return $this->hasMany(Notifikasi::class, 'user_id', 'user_id');
    }

    /**
     * Relasi ke pembayaran yang terkait dengan user.
     * Menggunakan type hint HasMany untuk kejelasan.
     */
    public function pembayaran(): HasMany
    {
        // Asumsi tabel 'pembayaran' memiliki kolom 'user_id' yang merujuk ke 'user_id' di tabel 'users'.
        return $this->hasMany(Pembayaran::class, 'user_id', 'user_id');
    }

    /**
     * Relasi ke pesan yang dikirim oleh user.
     * Menggunakan type hint HasMany untuk kejelasan.
     */
    public function pesanDikirim(): HasMany
    {
        // Asumsi tabel 'pesan' memiliki kolom 'pengirim_id' yang merujuk ke 'user_id' di tabel 'users'.
        return $this->hasMany(Pesan::class, 'pengirim_id', 'user_id');
    }

    /**
     * Relasi ke pesan yang diterima oleh user.
     * Menggunakan type hint HasMany untuk kejelasan.
     */
    public function pesanDiterima(): HasMany
    {
        // Asumsi tabel 'pesan' memiliki kolom 'penerima_id' yang merujuk ke 'user_id' di tabel 'users'.
        return $this->hasMany(Pesan::class, 'penerima_id', 'user_id');
    }

    // Metode `isActive()` tidak perlu diubah, sudah benar.
    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }

    // `setPasswordAttribute` tidak diperlukan jika Anda menggunakan `password` => `hashed` di $casts
    // dan Laravel otomatis akan meng-hashnya saat disimpan melalui model.
    // Jika Anda secara manual melakukan `Hash::make()` di controller, pastikan itu dilakukan sebelum menyimpan.
}