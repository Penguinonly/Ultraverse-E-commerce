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
        Schema::table('dokumen', function (Blueprint $table) {
            if (!Schema::hasColumn('dokumen', 'properti_id')) {
                $table->integer('properti_id')->after('dokumen_id');
            }
            if (!Schema::hasColumn('dokumen', 'file_path')) {
                $table->string('file_path')->after('properti_id');
            }
            if (!Schema::hasColumn('dokumen', 'status')) {
                $table->string('status')->default('pending')->after('file_path');
            }
            
            // Tambah foreign key
            $table->foreign('properti_id')
                  ->references('properti_id')
                  ->on('properti')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dokumen', function (Blueprint $table) {
            $table->dropForeign(['properti_id']);
            $table->dropColumn(['properti_id', 'file_path', 'status']);
        });
    }
};
