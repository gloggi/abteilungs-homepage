<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPostsItem extends Model
{
    use HasFactory;

    protected $fillable = ['page_id', 'blog_post_id', 'sort', 'view_mode'];

    protected $appends = ['type'];

    public function getTypeAttribute()
    {
        return 'blogPostsItem';
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function blogPost()
    {
        return $this->belongsTo(BlogPost::class);
    }

    public function blogPosts()
    {
        return $this->belongsToMany(BlogPost::class, 'blog_posts_item_blog_post');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
