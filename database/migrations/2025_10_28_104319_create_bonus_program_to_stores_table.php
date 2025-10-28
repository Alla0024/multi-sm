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
        Schema::create('bonus_program_to_stores', function (Blueprint $table) {
            $table->unsignedInteger('bonus_program_id');
            $table->unsignedBigInteger('store_id');

            $table->primary(['bonus_program_id', 'store_id']);

            $table->foreign('bonus_program_id')->references('id')->on('bonus_programs')->onDelete('cascade');
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bonus_program_to_stores');
    }
};
