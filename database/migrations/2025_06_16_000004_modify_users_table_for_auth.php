<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambah kolom yang diperlukan untuk login dan data user
            if (!Schema::hasColumn('users', 'email')) {
                $table->string('email')->unique();
            }
            if (!Schema::hasColumn('users', 'password')) {
                $table->string('password');
            }
            if (!Schema::hasColumn('users', 'nama')) {
                $table->string('nama');
            }
            if (!Schema::hasColumn('users', 'noktp')) {
                $table->string('noktp')->unique();
            }
            if (!Schema::hasColumn('users', 'no_telepon')) {
                $table->string('no_telepon')->nullable();
            }
            if (!Schema::hasColumn('users', 'alamat')) {
                $table->text('alamat')->nullable();
            }
            if (!Schema::hasColumn('users', 'foto_ktp')) {
                $table->string('foto_ktp')->nullable();
            }
            if (!Schema::hasColumn('users', 'verivikasi_wajah')) {
                $table->boolean('verivikasi_wajah')->default(false);
            }
            if (!Schema::hasColumn('users', 'remember_token')) {
                $table->rememberToken();
            }
            if (!Schema::hasColumn('users', 'id_peran')) {
                $table->unsignedInteger('id_peran')->nullable();
                $table->foreign('id_peran')
                    ->references('id_peran')
                    ->on('peran')
                    ->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign key terlebih dahulu
            $table->dropForeign(['id_peran']);
            
            // Drop kolom
            $table->dropColumn([
                'email',
                'password',
                'nama',
                'noktp',
                'no_telepon',
                'alamat',
                'foto_ktp',
                'verivikasi_wajah',
                'remember_token',
                'id_peran'
            ]);
        });
    }
};
