<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('route')->unique()->nullable();
            $table->boolean('big_header')->default(false);
            $table->timestamps();
        });

        Schema::create('page_file', function (Blueprint $table) {
            $table->foreignId('page_id')->constrained()->onDelete('cascade');
            $table->foreignId('file_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('text_items', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('body')->nullable();
            $table->boolean('show_fleur_de_lis')->default(false);
            $table->integer('sort')->nullable();
            $table->unsignedBigInteger('page_id');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('image_items', function (Blueprint $table) {
            $table->id();
            $table->integer('sort')->nullable();
            $table->unsignedBigInteger('page_id');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('image_item_file', function (Blueprint $table) {
            $table->foreignId('image_item_id')->constrained()->onDelete('cascade');
            $table->foreignId('file_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('form_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('sort')->nullable();
            $table->unsignedBigInteger('page_id');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('files_items', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->integer('sort')->nullable();
            $table->unsignedBigInteger('page_id');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('files_item_file', function (Blueprint $table) {
            $table->foreignId('files_item_id')->constrained()->onDelete('cascade');
            $table->foreignId('file_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('generic_items', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->integer('sort')->nullable();
            $table->unsignedBigInteger('page_id');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->timestamps();
        });

    }

    public function down()
    {

        Schema::dropIfExists('files_item_file');
        Schema::dropIfExists('generic_items');
        Schema::dropIfExists('form_items');
        Schema::dropIfExists('image_item_file');
        Schema::dropIfExists('image_items');
        Schema::dropIfExists('text_items');
        Schema::dropIfExists('page_file');
        Schema::dropIfExists('files_items');
        Schema::dropIfExists('pages');
    }
}
