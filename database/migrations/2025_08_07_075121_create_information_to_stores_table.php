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
        Schema::create('information_to_stores', function (Blueprint $table) {
            $table->foreignId('information_id')->constrained('informations');
            $table->foreignId('store_id')->constrained('stores');
            $table->primary(['information_id', 'store_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('information_to_stores');
    }
};
