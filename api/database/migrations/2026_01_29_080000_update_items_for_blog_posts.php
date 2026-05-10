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
        $tables = [
            'text_items',
            'image_items',
            'form_items',
            'files_items',
            'location_items',
            'faq_items',
            'group_events_items',
            'camp_items',
            'contact_items',
            'generic_items',
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->foreignId('page_id')->nullable()->change();
                $table->foreignId('blog_post_id')->nullable()->constrained('blog_posts')->cascadeOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'text_items',
            'image_items',
            'form_items',
            'files_items',
            'location_items',
            'faq_items',
            'group_events_items',
            'camp_items',
            'contact_items',
            'generic_items',
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropForeign(['blog_post_id']);
                $table->dropColumn('blog_post_id');
                // Revert page_id to not nullable
                $table->foreignId('page_id')->nullable(false)->change();
            });
        }
    }
};
