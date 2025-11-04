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
        Schema::table('shops', function (Blueprint $table) {
            $table->unsignedBigInteger('postcode_id')->nullable()->after('location_id');

            $table->foreign('postcode_id')
                ->references('id')
                ->on('postcodes')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->dropForeign(['postcode_id']);
            $table->dropColumn('postcode_id');
        });
    }
};
