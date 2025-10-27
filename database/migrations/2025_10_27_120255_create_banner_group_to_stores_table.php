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
        Schema::create('banner_group_to_stores', function (Blueprint $table) {
                $table->unsignedInteger('banner_group_id');
                $table->unsignedBigInteger('store_id');

                $table->primary(['banner_group_id', 'store_id']);

                $table->foreign('banner_group_id')->references('id')->on('banner_groups')->onDelete('cascade');
                $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banner_group_to_stores');
    }
};
