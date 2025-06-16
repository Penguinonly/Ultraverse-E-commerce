<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('peran')) {
            Schema::create('peran', function (Blueprint $table) {
                $table->increments('id_peran');
                $table->string('nama_peran', 50);
                $table->string('deskripsi')->nullable();
                $table->timestamps();
            });

            // Insert default roles
            DB::table('peran')->insert([
                ['nama_peran' => 'admin', 'deskripsi' => 'Administrator sistem'],
                ['nama_peran' => 'penjual', 'deskripsi' => 'Penjual properti'],
                ['nama_peran' => 'pembeli', 'deskripsi' => 'Pembeli properti'],
                ['nama_peran' => 'inspektur', 'deskripsi' => 'Inspektur properti']
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peran');
    }
};
