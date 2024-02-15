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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->unsignedBigInteger('start_location_id')->nullable();
            $table->foreign('start_location_id')->references('id')->on('locations')->onDelete('set null');
            $table->unsignedBigInteger('end_location_id')->nullable();
            $table->foreign('end_location_id')->references('id')->on('locations')->onDelete('set null');
            $table->text('description')->nullable();
            $table->text('take_with_you')->nullable();
            $table->integer('midata_id')->nullable();
            $table->string('external_application_link')->nullable();
            $table->timestamps();
        });
        Schema::create('event_groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('group_id');
            $table->timestamps();
        
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_groups');
        Schema::dropIfExists('events');
    }
};
