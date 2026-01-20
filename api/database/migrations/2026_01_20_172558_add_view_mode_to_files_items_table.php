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
        Schema::table('files_items', function (Blueprint $table) {
            $table->enum('view_mode', ['gallery', 'list'])->default('gallery');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('files_items', function (Blueprint $table) {
            $table->dropColumn('view_mode');
        });
    }
};
