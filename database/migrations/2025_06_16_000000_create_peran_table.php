<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('peran', function (Blueprint $table) {
            $table->id('id_peran');
            $table->string('Peran', 50)->nullable();
            $table->timestamps();
        });

        // Insert default roles
        DB::table('peran')->insert([
            ['Peran' => 'admin'],
            ['Peran' => 'penjual'],
            ['Peran' => 'pembeli']
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('peran');
    }
};
