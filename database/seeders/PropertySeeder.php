<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property; // Pastikan model ini ada dan benar
use App\Models\User;     // Pastikan model ini ada dan benar
use Illuminate\Support\Facades\Hash; // Tambahkan ini untuk Hash::make()

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Membuat atau mencari user 'admin'
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'], // Kondisi pencarian
            [
                'nama' => 'Admin User', // Ganti 'name' menjadi 'nama' sesuai skema DB
                'password' => Hash::make('password'), // Gunakan Hash::make()
                'role' => 'admin', // Tambahkan kolom 'role' dengan nilai 'admin'
                'no_telepon' => '08123456789', // Contoh, sesuaikan jika ada batasan NOT NULL
                'alamat' => 'Jl. Admin No. 1', // Contoh
                'pendapatan_perbulan' => 0, // Contoh
                'is_active' => true, // Default sudah true di migrasi, tapi bisa ditulis eksplisit
                'nama_toko' => null, // Contoh, sesuaikan
            ]
        );

        // 2. Membuat atau mencari user 'penjual'
        $sellerUser = User::firstOrCreate(
            ['email' => 'penjual@example.com'],
            [
                'nama' => 'Penjual User',
                'password' => Hash::make('password'),
                'role' => 'penjual', // Tambahkan kolom 'role' dengan nilai 'penjual'
                'no_telepon' => '081987654321',
                'alamat' => 'Jl. Penjual No. 2',
                'pendapatan_perbulan' => 5000000,
                'is_active' => true,
                'nama_toko' => 'Toko Properti ABC',
            ]
        );

        // 3. Membuat atau mencari user 'pembeli'
        $buyerUser = User::firstOrCreate(
            ['email' => 'pembeli@example.com'],
            [
                'nama' => 'Pembeli User',
                'password' => Hash::make('password'),
                'role' => 'pembeli', // Tambahkan kolom 'role' dengan nilai 'pembeli'
                'no_telepon' => '081122334455',
                'alamat' => 'Jl. Pembeli No. 3',
                'pendapatan_perbulan' => 0,
                'is_active' => true,
                'nama_toko' => null,
            ]
        );

        // Contoh properti yang dibuat oleh penjual ($sellerUser)
        $properties = [
            [
                'judul' => 'Rumah Modern Minimalis', // Menggunakan 'judul' sesuai migrasi 'properti'
                'deskripsi' => 'Rumah idaman dengan desain modern dan minimalis.',
                'lokasi' => 'PAREPARE, SULAWESI SELATAN',
                'harga' => 850000000,
                'status' => 'Lulus Uji',
                'user_id' => $sellerUser->user_id, // Menggunakan user_id dari sellerUser
                // Hapus kolom yang tidak ada di tabel 'properti' seperti image_url, bedrooms, bathrooms, area
                // Jika Anda ingin menyimpan ini, Anda perlu membuat tabel terpisah (misal: 'detail_properti' atau 'gambar_properti')
            ],
            [
                'judul' => 'Rumah Minimalis Elegan',
                'deskripsi' => 'Rumah elegan dengan fasilitas lengkap.',
                'lokasi' => 'PAREPARE, SULAWESI SELATAN',
                'harga' => 1250000000,
                'status' => 'Lulus Uji',
                'user_id' => $sellerUser->user_id,
            ],
            [
                'judul' => 'Rumah Klasik Asri',
                'deskripsi' => 'Rumah dengan arsitektur klasik dan taman yang asri.',
                'lokasi' => 'PAREPARE, SULAWESI SELATAN',
                'harga' => 1450000000,
                'status' => 'Lulus Uji',
                'user_id' => $sellerUser->user_id,
            ],
        ];

        foreach ($properties as $property) {
            Property::create($property); // Langsung create karena user_id sudah ada di $property
        }
    }
}