<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('category');
        $table->string('sub_category');
        $table->string('fabric');
        $table->integer('GSM');
        $table->decimal('price', 8, 2);
        $table->text('description')->nullable();
        $table->unsignedBigInteger('created_by');
        $table->unsignedBigInteger('modified_by')->nullable();
        $table->softDeletes(); // Adds a deleted_at column for soft deletes
        $table->timestamps();
        
        $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
