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
        Schema::table('text_items', function (Blueprint $table) {
            $table->foreignId('group_id')->nullable()->after('body')->constrained();
            $table->foreignId('section_id')->nullable()->after('group_id')->constrained();
        });

        $pfadistufeSectionId = DB::table('sections')
            ->where('name', 'Pfadistufe')
            ->value('id');

        DB::table('text_items')
            ->whereNotNull('show_fleur_de_lis')
            ->where('show_fleur_de_lis', true)
            ->update(['section_id' => $pfadistufeSectionId]);

        Schema::table('text_items', function (Blueprint $table) {
            $table->dropColumn('show_fleur_de_lis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('text_items', function (Blueprint $table) {
            $table->boolean('show_fleur_de_lis')->default(false)->after('body');
        });

        $pfadistufeSectionId = DB::table('sections')
            ->where('name', 'Pfadistufe')
            ->value('id');

        DB::table('text_items')
            ->where('section_id', $pfadistufeSectionId)
            ->update(['show_fleur_de_lis' => true]);

        DB::table('text_items')
            ->where('section_id', '<>', $pfadistufeSectionId)
            ->update(['show_fleur_de_lis' => false]);

        Schema::table('text_items', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
            $table->dropForeign(['section_id']);
            $table->dropColumn('group_id');
            $table->dropColumn('section_id');
        });
    }
};
