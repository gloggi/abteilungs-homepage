<?php

namespace App\Models;

use App\Traits\HasPageItems;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    use HasFactory, HasPageItems;

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    protected $fillable = ['title', 'slug', 'published_at', 'active', 'user_id', 'author', 'preview_image_id'];

    protected $casts = [
        'published_at' => 'datetime',
        'active' => 'boolean',
    ];

    public function getItemForeignKey()
    {
        return 'blog_post_id';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function previewImage()
    {
        return $this->belongsTo(File::class, 'preview_image_id');
    }

    public function files()
    {
        return $this->belongsToMany(File::class, 'blog_post_file');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($blogPost) {
            if (!$blogPost->slug) {
                $blogPost->slug = Str::slug($blogPost->title);
            }
        });
    }
}
