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
        Schema::create('camp_groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('camp_id');
            $table->unsignedBigInteger('group_id');
            $table->timestamps();

            $table->foreign('camp_id')->references('id')->on('camps')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camp_groups');

    }
};
