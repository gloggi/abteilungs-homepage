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
            $table->string('alert_text')->nullable()->after('contact_in_footer');
            $table->string('alert_bg_color')->nullable()->after('alert_text');
            $table->string('alert_text_color')->nullable()->after('alert_bg_color');
            $table->boolean('show_alert')->default(false)->after('alert_text_color');
            $table->string('alert_url')->nullable()->after('show_alert');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('alert_text');
            $table->dropColumn('alert_bg_color');
            $table->dropColumn('alert_text_color');
            $table->dropColumn('show_alert');
            $table->dropColumn('alert_url');
        });
    }
};
