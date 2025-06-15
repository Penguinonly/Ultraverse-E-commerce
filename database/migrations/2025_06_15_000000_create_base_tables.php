<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Users table with additional fields
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role')->default('pembeli');
            $table->string('no_telepon')->nullable();
            $table->text('alamat')->nullable();
            $table->string('noktp')->unique()->nullable();
            $table->string('foto_ktp')->nullable();
            $table->string('verifikasi_wajah')->nullable();
            $table->decimal('pendapatan_perbulan', 15, 2)->nullable();
            $table->string('avatar')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // Properties table
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type');
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 15, 2);
            $table->string('location');
            $table->string('status')->default('available');
            $table->json('features')->nullable();
            $table->timestamps();
        });

        // Saved Properties table
        Schema::create('saved_properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->timestamp('tanggal_disimpan');
            $table->timestamps();
        });

        // Documents table
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('property_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('type');
            $table->string('filename');
            $table->string('path');
            $table->text('description')->nullable();
            $table->string('status')->default('pending');
            $table->timestamp('tanggal_upload');
            $table->timestamps();
        });

        // Property Images table
        Schema::create('property_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->string('filename');
            $table->string('path');
            $table->boolean('is_primary')->default(false);
            $table->timestamp('tanggal_upload');
            $table->timestamps();
        });

        // Payments table
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique();
            $table->foreignId('property_id')->constrained();
            $table->foreignId('buyer_id')->constrained('users');
            $table->foreignId('seller_id')->constrained('users');
            $table->decimal('amount', 15, 2);
            $table->string('payment_method');
            $table->string('status')->default('pending');
            $table->timestamp('payment_date')->nullable();
            $table->timestamps();
        });

        // User Settings table
        Schema::create('user_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->json('notification_preferences')->nullable();
            $table->string('language')->default('id');
            $table->json('payment_methods')->nullable();
            $table->timestamps();
        });

        // Sessions table
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->text('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('user_settings');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('property_images');
        Schema::dropIfExists('documents');
        Schema::dropIfExists('saved_properties');
        Schema::dropIfExists('properties');
        Schema::dropIfExists('users');
    }
};
