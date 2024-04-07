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
        Schema::table('forms', function (Blueprint $table) {
            $table->boolean('enable_autoresponse')->default(false);
            $table->string('autoresponse_subject')->nullable();
            $table->text('autoresponse_message')->nullable();
            $table->unsignedBigInteger('autoresponse_email_field_id')->nullable();
            $table->foreign('autoresponse_email_field_id')->references('id')->on('text_fields')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->dropColumn('enable_autoresponse');
            $table->dropColumn('autoresponse_subject');
            $table->dropColumn('autoresponse_message');
            $table->dropForeign(['autoresponse_email_field_id']);
            $table->dropColumn('autoresponse_email_field_id');
        });
    }
};
