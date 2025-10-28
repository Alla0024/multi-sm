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
        Schema::create('promo_code_group_to_stores', function (Blueprint $table) {
            $table->unsignedInteger('promo_code_group_id');
            $table->unsignedBigInteger('store_id');

            $table->primary(['promo_code_group_id', 'store_id']);

            $table->foreign('promo_code_group_id')->references('id')->on('promo_code_groups')->onDelete('cascade');
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_code_group_to_stores');
    }
};
