<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pesan', function (Blueprint $table) {
            $table->unsignedBigInteger('pengirim_id')->after('id');
            $table->unsignedBigInteger('penerima_id')->after('pengirim_id');
            $table->text('isi_pesan')->after('penerima_id');
            $table->boolean('dibaca')->default(false)->after('isi_pesan');
            $table->timestamp('timestamp')->useCurrent()->after('dibaca');

            // Foreign key ke tabel users (pastikan tabel 'users' sudah ada)
            $table->foreign('pengirim_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('penerima_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pesan', function (Blueprint $table) {
            // Hapus foreign key terlebih dahulu sebelum drop kolom
            $table->dropForeign(['pengirim_id']);
            $table->dropForeign(['penerima_id']);

            // Hapus kolom
            $table->dropColumn(['pengirim_id', 'penerima_id', 'isi_pesan', 'dibaca', 'timestamp']);
        });
    }
};
