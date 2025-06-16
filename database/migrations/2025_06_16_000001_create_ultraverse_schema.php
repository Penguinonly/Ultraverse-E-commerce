<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Users table
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('password');
            $table->string('noktp')->unique();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('no_telepon');
            $table->text('alamat');
            $table->string('foto_ktp');
            $table->string('verifikasi_wajah')->nullable();
            $table->decimal('pendapatan_perbulan', 15, 2);
            $table->enum('role', ['admin', 'penjual', 'pembeli']);
            $table->timestamps();
        });

        // Properti table
        Schema::create('properti', function (Blueprint $table) {
            $table->id('properti_id');
            $table->foreignId('user_id')->constrained('users', 'user_id');
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('tipe');
            $table->decimal('harga', 15, 2);
            $table->string('lokasi');
            $table->string('status')->default('pending');
            $table->timestamps();
        });

        // Gambar Properti table
        Schema::create('gambar_properti', function (Blueprint $table) {
            $table->id('gambar_id');
            $table->foreignId('properti_id')->constrained('properti', 'properti_id')->onDelete('cascade');
            $table->string('nama_file');
            $table->datetime('tanggal_upload');
            $table->timestamps();
        });

        // Dokumen table
        Schema::create('dokumen', function (Blueprint $table) {
            $table->id('dokumen_id');
            $table->foreignId('properti_id')->constrained('properti', 'properti_id')->onDelete('cascade');
            $table->string('nama_file');
            $table->string('tipe_dokumen');
            $table->datetime('tanggal_upload');
            $table->timestamps();
        });

        // Favorit/SavedProperty table
        Schema::create('favorit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->foreignId('properti_id')->constrained('properti', 'properti_id')->onDelete('cascade');
            $table->datetime('tanggal_disimpan');
            $table->timestamps();
        });

        // Transaksi table
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('transaksi_id');
            $table->foreignId('properti_id')->constrained('properti', 'properti_id');
            $table->foreignId('buyer_id')->constrained('users', 'user_id');
            $table->foreignId('seller_id')->constrained('users', 'user_id');
            $table->decimal('total_harga', 15, 2);
            $table->string('status')->default('pending');
            $table->timestamps();
        });

        // Pembayaran table
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('pembayaran_id');
            $table->foreignId('transaksi_id')->constrained('transaksi', 'transaksi_id');
            $table->decimal('jumlah', 15, 2);
            $table->string('metode_pembayaran');
            $table->boolean('konfirmasi_pembayaran')->default(false);
            $table->timestamps();
        });

        // Notifikasi table
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id('notifikasi_id');
            $table->foreignId('user_id')->constrained('users', 'user_id');
            $table->string('judul');
            $table->text('pesan');
            $table->string('tipe');
            $table->boolean('dibaca')->default(false);
            $table->datetime('tanggal');
            $table->timestamps();
        });

        // Pesan table
        Schema::create('pesan', function (Blueprint $table) {
            $table->id('pesan_id');
            $table->foreignId('pengirim_id')->constrained('users', 'user_id');
            $table->foreignId('penerima_id')->constrained('users', 'user_id');
            $table->text('isi_pesan');
            $table->boolean('dibaca')->default(false);
            $table->timestamp('timestamp')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pesan');
        Schema::dropIfExists('notifikasi');
        Schema::dropIfExists('pembayaran');
        Schema::dropIfExists('transaksi');
        Schema::dropIfExists('favorit');
        Schema::dropIfExists('dokumen');
        Schema::dropIfExists('gambar_properti');
        Schema::dropIfExists('properti');
        Schema::dropIfExists('users');
    }
};
