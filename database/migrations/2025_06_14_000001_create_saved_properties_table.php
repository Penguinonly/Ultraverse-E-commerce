<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('saved_properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            // Memastikan user tidak bisa menyimpan properti yang sama lebih dari sekali
            $table->unique(['user_id', 'property_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('saved_properties');
    }
};
