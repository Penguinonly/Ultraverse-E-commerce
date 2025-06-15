<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->json('notification_preferences')->nullable();
            $table->json('payment_methods')->nullable();
            $table->string('language')->default('en');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_settings');
    }
};
