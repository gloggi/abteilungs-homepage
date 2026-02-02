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
            $table->string('navbar_font_color')->default('#ffffff')->after('secondary_color');
            $table->enum('navbar_position', ['top', 'between_header_and_content'])->default('between_header_and_content')->after('navbar_font_color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            if (Schema::hasColumn('settings', 'navbar_position')) {
                $table->dropColumn('navbar_position');
            }

            if (Schema::hasColumn('settings', 'navbar_font_color')) {
                $table->dropColumn('navbar_font_color');
            }
        });
    }
};
