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

        Schema::create('page_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained()->onDelete('cascade');
            $table->integer('sort')->default(0);
            $table->string('type');
            $table->timestamps();
        });

        Schema::create('text_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_item_id')->constrained()->onDelete('cascade');
            $table->string('title')->nullable();
            $table->text('body')->nullable();
            $table->timestamps();
        });

        Schema::create('image_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_item_id')->constrained()->onDelete('cascade');
            $table->foreignId('file_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pages');
        Schema::dropIfExists('page_items');
        Schema::dropIfExists('text_items');
        Schema::dropIfExists('image_items');
    }
}
