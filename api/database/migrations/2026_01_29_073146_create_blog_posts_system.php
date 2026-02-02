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
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->boolean('active')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->string('author')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('preview_image_id')->nullable()->constrained('files')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('blog_posts_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('blog_post_id')->nullable()->constrained('blog_posts')->cascadeOnDelete();
            $table->integer('sort')->default(0);
            $table->string('view_mode')->default('all');
            $table->timestamps();
        });

        Schema::create('blog_posts_item_blog_post', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_posts_item_id')->constrained('blog_posts_items')->cascadeOnDelete();
            $table->foreignId('blog_post_id')->constrained('blog_posts')->cascadeOnDelete();
        });

        Schema::create('blog_post_file', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_post_id')->constrained('blog_posts')->cascadeOnDelete();
            $table->foreignId('file_id')->constrained('files')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_post_file');
        Schema::dropIfExists('blog_posts_item_blog_post');
        Schema::dropIfExists('blog_posts_items');
        Schema::dropIfExists('blog_posts');
    }
};
