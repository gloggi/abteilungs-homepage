<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name', 'slug'];

    public function posts()
    {
        return $this->morphedByMany(BlogPost::class, 'taggable');
    }

    public function blogPostsItems()
    {
        return $this->morphedByMany(BlogPostsItem::class, 'taggable');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tag) {
            if (!$tag->slug) {
                $tag->slug = \Illuminate\Support\Str::slug($tag->name);
            }
        });
    }
}
