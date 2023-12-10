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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_title')->nullable();
            $table->string('division_name')->nullable();
            $table->unsignedBigInteger('division_logo_id')->nullable();
            $table->foreign('division_logo_id')->references('id')->on('files')->onDelete('set null');
            $table->unsignedBigInteger('website_icon_id')->nullable();
            $table->foreign('website_icon_id')->references('id')->on('files')->onDelete('set null');
            $table->string('primary_color')->nullable();
            $table->string('secondary_color')->nullable();
            $table->text('contact_in_footer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
