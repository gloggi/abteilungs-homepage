<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('subject')->nullable();
            $table->string('message')->nullable();
            $table->timestamps();
        });

        Schema::create('text_fields', function (Blueprint $table) {
            $table->id();
            $table->string('label')->nullable();
            $table->string('input_type')->nullable();
            $table->boolean('required')->default(false);
            $table->integer('sort')->nullable();
            $table->unsignedBigInteger('form_id');
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('textarea_fields', function (Blueprint $table) {
            $table->id();
            $table->string('label')->nullable();
            $table->boolean('required')->default(false);
            $table->integer('sort')->nullable();
            $table->unsignedBigInteger('form_id');
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('select_fields', function (Blueprint $table) {
            $table->id();
            $table->string('label')->nullable();
            $table->boolean('required')->default(false);
            $table->integer('sort')->nullable();
            $table->unsignedBigInteger('form_id');
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('option_fields', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('sort')->nullable();
            $table->unsignedBigInteger('select_field_id');
            $table->foreign('select_field_id')->references('id')->on('select_fields')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('option_fields');
        Schema::dropIfExists('select_fields');
        Schema::dropIfExists('text_fields');
        Schema::dropIfExists('textarea_fields');
        Schema::dropIfExists('forms');
    }
};
