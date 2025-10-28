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
        Schema::create('sale_to_stores', function (Blueprint $table) {
            $table->unsignedInteger('sale_id');
            $table->unsignedBigInteger('store_id');

            $table->primary(['sale_id', 'store_id']);

            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_to_stores');
    }
};
