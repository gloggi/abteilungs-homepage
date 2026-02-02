<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactItem extends Model
{
    protected $fillable = ['page_id', 'blog_post_id', 'type', 'sort'];

    protected $with = ['groups'];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'contact_item_group');
    }
}
