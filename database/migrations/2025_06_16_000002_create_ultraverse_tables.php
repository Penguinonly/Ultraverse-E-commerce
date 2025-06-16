<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('properti', function (Blueprint $table) {
            $table->id('properti_id');
            $table->foreignId('user_id')->constrained('users');
            $table->string('nama_properti');
            $table->text('deskripsi');
            $table->string('lokasi');
            $table->decimal('harga', 15, 2);
            $table->string('status');
            $table->string('tipe_properti');
            $table->timestamps();
        });

        Schema::create('gambar_properti', function (Blueprint $table) {
            $table->id('gambar_id');
            $table->foreignId('properti_id')->constrained('properti');
            $table->string('url_gambar');
            $table->datetime('tanggal_upload')->nullable();
            $table->timestamps();
        });

        Schema::create('dokumen', function (Blueprint $table) {
            $table->id('dokumen_id');
            $table->foreignId('properti_id')->constrained('properti');
            $table->string('nama_dokumen');
            $table->string('url_dokumen');
            $table->datetime('tanggal_upload')->nullable();
            $table->timestamps();
        });

        Schema::create('favorit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('properti_id')->constrained('properti');
            $table->datetime('tanggal_disimpan')->nullable();
            $table->timestamps();
        });

        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('transaksi_id');
            $table->foreignId('properti_id')->constrained('properti');
            $table->foreignId('pembeli_id')->constrained('users');
            $table->foreignId('penjual_id')->constrained('users');
            $table->decimal('total_harga', 15, 2)->nullable();
            $table->string('status_transaksi');
            $table->timestamps();
        });

        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('pembayaran_id');
            $table->foreignId('transaksi_id')->constrained('transaksi');
            $table->decimal('jumlah', 15, 2);
            $table->string('metode_pembayaran');
            $table->boolean('konfirmasi_pembayaran')->nullable();
            $table->timestamps();
        });

        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id('notifikasi_id');
            $table->foreignId('user_id')->constrained('users');
            $table->string('judul');
            $table->text('pesan');
            $table->boolean('dibaca')->default(false);
            $table->datetime('tanggal')->nullable();
            $table->timestamps();
        });

        Schema::create('pesan', function (Blueprint $table) {
            $table->id('pesan_id');
            $table->foreignId('pengirim_id')->constrained('users');
            $table->foreignId('penerima_id')->constrained('users');
            $table->text('isi_pesan');
            $table->boolean('dibaca')->default(false);
            $table->timestamp('timestamp')->nullable();
            $table->timestamps();
        });

        Schema::create('laporan_inspeksi', function (Blueprint $table) {
            $table->id('laporan_id');
            $table->foreignId('properti_id')->constrained('properti');
            $table->foreignId('inspector_id')->constrained('users');
            $table->text('hasil_inspeksi');
            $table->string('status_laporan', 20)->nullable();
            $table->timestamps();
        });

        Schema::create('rating_ulasan', function (Blueprint $table) {
            $table->id('ulasan_id');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('properti_id')->constrained('properti');
            $table->integer('rating');
            $table->text('ulasan');
            $table->datetime('tanggal')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rating_ulasan');
        Schema::dropIfExists('laporan_inspeksi');
        Schema::dropIfExists('pesan');
        Schema::dropIfExists('notifikasi');
        Schema::dropIfExists('pembayaran');
        Schema::dropIfExists('transaksi');
        Schema::dropIfExists('favorit');
        Schema::dropIfExists('dokumen');
        Schema::dropIfExists('gambar_properti');
        Schema::dropIfExists('properti');
    }
};
