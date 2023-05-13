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
            $table->string('title')->nullable();
            $table->string('route')->nullable();
            $table->timestamps();
        });


        Schema::create('text_items', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('body')->nullable();
            $table->integer('sort')->nullable();
            $table->unsignedBigInteger('page_id');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('image_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('file_id')->nullable()->default(null);
            $table->integer('sort')->nullable();
            $table->unsignedBigInteger('page_id');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pages');
        Schema::dropIfExists('text_items');
        Schema::dropIfExists('image_items');
    }
}
