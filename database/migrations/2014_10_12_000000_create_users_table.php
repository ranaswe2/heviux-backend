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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('image_name')->nullable();
            $table->string('image_path')->nullable();
            $table->string('password');
            $table->string('address')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->string('current_otp')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
            $table->rememberToken();
            $table->softDeletes(); // Adds a deleted_at column for soft deletes
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
