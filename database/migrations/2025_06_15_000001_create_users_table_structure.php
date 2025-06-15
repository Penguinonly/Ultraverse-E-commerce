<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('password');
            $table->unsignedBigInteger('noktp')->unique();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('no_telepon', 20);
            $table->text('alamat');
            $table->binary('foto_ktp')->nullable();
            $table->binary('verifikasi_wajah')->nullable();
            $table->integer('pendapatan_perbulan');
            $table->enum('role', ['admin', 'penjual', 'pembeli'])->default('pembeli');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
