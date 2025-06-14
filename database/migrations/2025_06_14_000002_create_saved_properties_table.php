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
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('property_id');
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            
            // We'll add this constraint only if the properties table exists
            if (Schema::hasTable('properties')) {
                $table->foreign('property_id')
                      ->references('id')
                      ->on('properties')
                      ->onDelete('cascade');
            }

            // Prevent duplicate saves
            $table->unique(['user_id', 'property_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('saved_properties');
    }
};
