<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    // 1. Tentukan nama tabel yang benar: 'properti', bukan 'properties'
    // Laravel secara default mencari nama tabel dalam bentuk plural dari nama model,
    // jadi 'Property' akan mencari 'properties'. Kita perlu mengesetnya secara eksplisit.
    protected $table = 'properti';

    // 2. Tentukan primary key yang benar: 'properti_id', bukan 'id'
    // Laravel secara default menganggap primary key adalah 'id'.
    protected $primaryKey = 'properti_id';

    // 3. Tentukan apakah primary key adalah auto-incrementing atau tidak.
    // Karena 'properti_id' adalah increments (auto-incrementing integer), ini tidak perlu diubah.
    // public $incrementing = true; // Ini adalah default, jadi opsional

    // 4. Pastikan kolom 'timestamps' default Laravel digunakan.
    // Migrasi Anda menggunakan $table->timestamps() di tabel 'properti',
    // jadi tidak perlu mengubah ini.
    // public $timestamps = true; // Ini adalah default, jadi opsional

    // 5. Perbaiki properti $fillable agar sesuai dengan nama kolom di migrasi Anda.
    // Migrasi Anda menggunakan 'judul', 'deskripsi', bukan 'title'.
    // Kolom seperti 'image_url', 'bedrooms', 'bathrooms', 'area' tidak ada di tabel 'properti' Anda.
    protected $fillable = [
        'judul',        // Mengganti 'title' menjadi 'judul'
        'deskripsi',    // Tambahkan 'deskripsi'
        'harga',
        'lokasi',
        'status',
        'user_id',
        // Hapus 'image_url', 'bedrooms', 'bathrooms', 'area' dari $fillable
        // karena kolom ini tidak ada di tabel 'properti' Anda.
        // Jika Anda ingin menyimpan data ini, Anda harus menambahkannya di migrasi 'properti'
        // atau menyimpannya di tabel terkait (misalnya, 'gambar_properti' untuk image_url).
    ];

    // 6. Sesuaikan $casts dengan kolom yang ada di tabel 'properti'
    protected $casts = [
        'harga' => 'decimal:2', // Mengganti 'price' menjadi 'harga'
        // Hapus 'area' karena kolom ini tidak ada di tabel 'properti' Anda.
    ];

    // 7. Perbaiki relasi `user` jika perlu. Secara default Laravel akan menebak FK,
    // tetapi lebih baik eksplisit jika nama kolom FK bukan 'user_id' atau PK bukan 'id'.
    // Dalam kasus ini, FK Anda adalah 'user_id' dan PK user adalah 'user_id', jadi ini sudah benar.
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id'); // Eksplisit lebih aman
    }

    // 8. Relasi 'savedBy'
    // Perhatikan bahwa di migrasi Anda tidak ada tabel 'saved_properties'.
    // Anda memiliki tabel 'favorit'. Jika 'favorit' adalah tabel pivot untuk many-to-many
    // antara users dan properti, maka ini perlu disesuaikan.
    // Asumsi 'favorit' adalah tabel pivot:
    public function savedBy()
    {
        return $this->belongsToMany(User::class, 'favorit', 'properti_id', 'user_id');
        // 'favorit' adalah nama tabel pivot
        // 'properti_id' adalah foreign key dari 'properti' di tabel 'favorit'
        // 'user_id' adalah foreign key dari 'users' di tabel 'favorit'
    }

    // 9. Perbaiki Accessor (getFormattedPriceAttribute)
    // Sesuaikan dengan nama kolom 'harga'
    public function getFormattedHargaAttribute() // Ganti nama method menjadi getFormattedHargaAttribute
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.'); // Mengganti $this->price menjadi $this->harga
    }

    // Jika Anda ingin tetap menggunakan getFormattedPriceAttribute, Anda bisa buat alias:
    public function getFormattedPriceAttribute()
    {
        return $this->getFormattedHargaAttribute();
    }
}