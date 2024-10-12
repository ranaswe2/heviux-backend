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
    Schema::create('delivery_charges', function (Blueprint $table) {
        $table->id();
        $table->decimal('price', 8, 2);
        $table->unsignedBigInteger('created_by');
        $table->unsignedBigInteger('modified_by')->nullable();
        $table->softDeletes();
        $table->timestamps();

        // Add foreign key constraints
        $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_charges');
    }
};
