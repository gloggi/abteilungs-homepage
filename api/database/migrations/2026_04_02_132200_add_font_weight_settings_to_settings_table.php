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
        Schema::table('settings', function (Blueprint $table) {
            $table->integer('font_weight_heading_1')->default(600)->nullable();
            $table->integer('font_weight_heading_2')->default(300)->nullable();
            $table->integer('font_weight_heading_3')->default(300)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['font_weight_heading_1', 'font_weight_heading_2', 'font_weight_heading_3']);
        });
    }
};
