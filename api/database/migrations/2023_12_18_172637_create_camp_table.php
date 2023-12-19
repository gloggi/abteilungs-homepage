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
        Schema::create('camps', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('cost', 5, 2)->nullable();
            $table->integer('maximum_participants')->nullable();
            $table->integer('participant_count')->default(0);
            $table->string('location')->nullable();
            $table->date('application_opening_at')->nullable();
            $table->date('application_closing_at')->nullable();
            $table->text('application_conditions')->nullable();
            $table->string('canton')->nullable();
            $table->string('external_application_link');
            $table->dateTime('start_at')->nullable();
            $table->dateTime('finish_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camps');
    }
};
