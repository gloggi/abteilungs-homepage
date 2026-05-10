<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->boolean('is_visible')->default(true);
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->boolean('is_visible')->default(true);
        });

        // Seed default hidden Section "Abteilung"
        $sectionId = DB::table('sections')->insertGetId([
            'name' => 'Abteilung',
            'is_visible' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Seed default hidden Group "Abteilungsstab"
        DB::table('groups')->insert([
            'name' => 'Abteilungsstab',
            'section_id' => $sectionId,
            'is_visible' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->dropColumn('is_visible');
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->dropColumn('is_visible');
        });

        // We probably shouldn't automatically delete the seeded data in down() as it might contain user changes
    }
};
