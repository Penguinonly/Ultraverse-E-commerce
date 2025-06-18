<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // =====================================================================
        // Core Tables (dibuat pertama karena direferensikan oleh banyak tabel lain)
        // =====================================================================

        // 1. users Table (primary: user_id)
        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_id'); // Sesuai `user_id` int PK di SQL
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('no_telepon', 20)->nullable();
            $table->string('alamat', 255)->nullable();
            // Catatan: Jika foto_ktp dan verifikasi_wajah menyimpan path file,
            // ubah tipe data ini menjadi $table->string('foto_ktp')->nullable();
            // dan $table->string('verifikasi_wajah')->nullable();
            $table->binary('foto_ktp')->nullable(); // `longblob` di MySQL -> `binary` di Laravel
            $table->binary('verifikasi_wajah')->nullable(); // `longblob` di MySQL -> `binary` di Laravel
            $table->integer('pendapatan_perbulan')->nullable();
            $table->enum('role', ['admin', 'penjual', 'pembeli']); // Sesuai ENUM di SQL
            $table->boolean('is_active')->default(true); // tinyint(1) default 1
            $table->string('nama_toko')->nullable();

            $table->timestamp('created_at')->nullable(); // Sesuai SQL
            $table->timestamp('updated_at')->nullable(); // Sesuai SQL
        });

        // 2. properti Table (Foreign key ke users)
        Schema::create('properti', function (Blueprint $table) {
            $table->increments('properti_id');
            $table->string('judul', 255)->nullable();
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 15, 2)->nullable();
            $table->text('lokasi')->nullable();
            $table->string('status', 20)->nullable();
            $table->unsignedInteger('user_id')->nullable(); // unsignedInteger karena FK ke int
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('set null'); // Menggunakan set null agar konsisten dengan FK lain

            $table->timestamps(); // Menambahkan timestamps Laravel standar, tidak ada di SQL asli
        });


        // =====================================================================
        // Related Tables (menggunakan foreign keys dari users dan properti)
        // =====================================================================

        // 3. dokumen Table (Foreign key ke properti dan users)
        Schema::create('dokumen', function (Blueprint $table) {
            $table->increments('dokumen_id');
            $table->unsignedInteger('properti_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->string('nama_dokumen', 255)->nullable();
            $table->text('file_path')->nullable();
            $table->string('status', 20)->nullable();
            $table->dateTime('tanggal_upload')->nullable();

            $table->foreign('properti_id')->references('properti_id')->on('properti')->onDelete('set null');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('set null');
            $table->timestamps(); // Menambahkan timestamps Laravel standar
        });

        // 4. favorit Table (Composite primary key, Foreign key ke users dan properti)
        Schema::create('favorit', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('properti_id');
            $table->dateTime('tanggal_disimpan')->nullable();

            $table->primary(['user_id', 'properti_id']); // Composite PK
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('properti_id')->references('properti_id')->on('properti')->onDelete('cascade');
            $table->timestamps(); // Menambahkan timestamps Laravel standar
        });

        // 5. gambar_properti Table (Foreign key ke properti)
        Schema::create('gambar_properti', function (Blueprint $table) {
            $table->increments('gambar_id');
            $table->unsignedInteger('properti_id')->nullable();
            $table->text('url_gambar')->nullable();
            $table->text('deskripsi')->nullable();
            $table->integer('urutan')->nullable();
            $table->dateTime('tanggal_upload')->nullable();

            $table->foreign('properti_id')->references('properti_id')->on('properti')->onDelete('set null');
            $table->timestamps(); // Menambahkan timestamps Laravel standar
        });

        // 6. laporan_inspeksi Table (Foreign key ke users dan properti)
        Schema::create('laporan_inspeksi', function (Blueprint $table) {
            $table->increments('laporan_id');
            $table->unsignedInteger('inspektor_id')->nullable(); // Asumsi ini FK ke user_id di users
            $table->unsignedInteger('properti_id')->nullable();
            $table->text('isi_laporan')->nullable();
            $table->dateTime('tanggal_inspeksi')->nullable();
            $table->string('status_laporan', 20)->nullable();

            $table->foreign('inspektor_id')->references('user_id')->on('users')->onDelete('set null');
            $table->foreign('properti_id')->references('properti_id')->on('properti')->onDelete('set null');
            $table->timestamps(); // Menambahkan timestamps Laravel standar
        });

        // 7. log_aktivitas Table (Foreign key ke users)
        Schema::create('log_aktivitas', function (Blueprint $table) {
            $table->increments('log_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->text('aktivitas')->nullable();
            $table->dateTime('waktu')->nullable();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('set null');
            $table->timestamps(); // Menambahkan timestamps Laravel standar
        });

        // 8. notifikasi Table (Foreign key ke users)
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->increments('notifikasi_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->text('isi_pesan')->nullable();
            $table->dateTime('tanggal')->nullable();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('set null');
            $table->timestamps(); // Menambahkan timestamps Laravel standar
        });

        // 9. Transaksi Table (foreign key ke users dan properti)
        Schema::create('transaksi', function (Blueprint $table) {
            $table->increments('transaksi_id');
            $table->unsignedInteger('pembeli_id')->nullable(); // int
            $table->unsignedInteger('properti_id')->nullable(); // int
            $table->dateTime('tanggal_transaksi')->nullable();
            $table->string('status_transaksi', 20)->nullable();
            $table->string('jenis_transaksi', 20)->nullable();
            $table->text('transaksi_admin')->nullable();
            $table->decimal('total_harga', 15, 2)->nullable();

            $table->foreign('pembeli_id')->references('user_id')->on('users')->onDelete('set null');
            $table->foreign('properti_id')->references('properti_id')->on('properti')->onDelete('set null');
            $table->timestamps(); // Menambahkan timestamps Laravel standar
        });

        // 10. Pembayaran Table (foreign key ke transaksi)
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->increments('pembayaran_id');
            $table->unsignedInteger('transaksi_id')->nullable(); // int
            $table->string('metode_pembayaran', 50)->nullable();
            $table->decimal('jumlah', 15, 2)->nullable();
            $table->dateTime('tanggal')->nullable();
            $table->string('status_pembayaran', 20)->nullable();
            $table->text('bukti_pembayaran')->nullable();
            $table->dateTime('tanggal_pembayaran')->nullable();
            $table->boolean('konfirmasi_pembayaran')->nullable(); // tinyint(1)

            $table->foreign('transaksi_id')->references('transaksi_id')->on('transaksi')->onDelete('set null');
            $table->timestamps(); // Menambahkan timestamps Laravel standar
        });

        // 11. Rating Ulasan Table (foreign key ke users dan properti)
        Schema::create('rating_ulasan', function (Blueprint $table) {
            $table->increments('ulasan_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('properti_id')->nullable();
            $table->integer('nilai_rating')->nullable();
            $table->text('komentar')->nullable();
            $table->dateTime('tanggal')->nullable();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('set null');
            $table->foreign('properti_id')->references('properti_id')->on('properti')->onDelete('set null');
            $table->timestamps(); // Menambahkan timestamps Laravel standar
        });

        // 12. Riwayat Properti Table (foreign key ke properti dan users)
        Schema::create('riwayat_properti', function (Blueprint $table) {
            $table->increments('riwayat_id');
            $table->unsignedInteger('properti_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->text('perubahan')->nullable();
            $table->dateTime('waktu')->nullable();

            $table->foreign('properti_id')->references('properti_id')->on('properti')->onDelete('set null');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('set null');
            $table->timestamps(); // Menambahkan timestamps Laravel standar
        });

        // 13. Pesan Table (foreign key ke users)
        Schema::create('pesan', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('pengirim', ['admin', 'pengguna']);
            $table->text('isi');
            $table->dateTime('waktu_kirim')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedInteger('user_id')->nullable(); // foreign key ke users.user_id
            $table->unsignedInteger('pengirim_id'); // Mengubah dari unsignedBigInteger ke unsignedInteger untuk konsistensi dengan users.user_id
            $table->unsignedInteger('penerima_id'); // Mengubah dari unsignedBigInteger ke unsignedInteger untuk konsistensi dengan users.user_id
            $table->text('isi_pesan'); // Duplikat dengan 'isi'? Tetap sesuai SQL.
            $table->boolean('dibaca');
            // Menghapus $table->timestamp('timestamp'); karena sudah ada $table->timestamps() di bawah
            
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('set null');
            // Menambahkan foreign keys untuk pengirim_id dan penerima_id ke users.user_id
            $table->foreign('pengirim_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('penerima_id')->references('user_id')->on('users')->onDelete('cascade');
            
            $table->timestamps(); // created_at, updated_at
        });

        // 14. Respon Logika Table
        Schema::create('respon_logika', function (Blueprint $table) {
            $table->increments('logika_id');
            $table->text('kata_kunci')->nullable();
            $table->text('respon')->nullable();
            $table->integer('prioritas')->default(1);
            $table->timestamps(); // Menambahkan timestamps Laravel standar
        });

        // 15. Tautan Histori Table (foreign key ke users)
        Schema::create('tautan_histori', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->text('link')->nullable();
            $table->dateTime('waktu_akses')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('set null');
            $table->timestamps(); // Menambahkan timestamps Laravel standar
        });

        // 16. Session Table (Sesuai SQL, Laravel defaultnya `sessions`)
        Schema::create('session', function (Blueprint $table) {
            $table->increments('session_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('status', 20)->nullable();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('set null');
            $table->timestamps(); // Menambahkan timestamps Laravel standar
        });

        // 17. Status Table (foreign key ke users, properti, transaksi, pembayaran)
        Schema::create('status', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('status_pembayaran', ['lunas', 'belum']);
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('properti_id')->nullable();
            $table->unsignedInteger('transaksi_id')->nullable();
            $table->unsignedInteger('pembayaran_id')->nullable();
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable(); // Menambahkan updated_at

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('set null');
            $table->foreign('properti_id')->references('properti_id')->on('properti')->onDelete('set null');
            $table->foreign('transaksi_id')->references('transaksi_id')->on('transaksi')->onDelete('set null');
            $table->foreign('pembayaran_id')->references('pembayaran_id')->on('pembayaran')->onDelete('set null');
        });

        // =====================================================================
        // Laravel Standard Tables (dibuat oleh migrasi bawaan, tidak perlu di sini)
        // =====================================================================
        // Schema::create('password_reset_tokens', function (Blueprint $table) { ... });
        // Schema::create('personal_access_tokens', function (Blueprint $table) { ... });
        // Schema::create('migrations', function (Blueprint $table) { ... });
        // Schema::create('posts', function (Blueprint $table) { ... }); // Ini juga tabel bawaan, jika tidak digunakan, bisa diabaikan
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Urutan drop tabel harus terbalik dari urutan create
        // Drop tabel yang memiliki foreign key terlebih dahulu.
        Schema::dropIfExists('status');
        Schema::dropIfExists('session');
        Schema::dropIfExists('tautan_histori');
        Schema::dropIfExists('respon_logika');
        Schema::dropIfExists('pesan');
        Schema::dropIfExists('riwayat_properti');
        Schema::dropIfExists('rating_ulasan');
        Schema::dropIfExists('pembayaran');
        Schema::dropIfExists('transaksi');
        Schema::dropIfExists('notifikasi');
        Schema::dropIfExists('log_aktivitas');
        Schema::dropIfExists('laporan_inspeksi');
        Schema::dropIfExists('gambar_properti');
        Schema::dropIfExists('favorit');
        Schema::dropIfExists('dokumen');
        Schema::dropIfExists('properti');
        Schema::dropIfExists('users');
    }
};