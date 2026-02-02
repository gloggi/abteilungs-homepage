<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Page extends Model
{
    use Searchable, \App\Traits\HasPageItems;

    protected $fillable = ['title', 'route', 'file_ids', 'big_header', 'group_id', 'password'];

    protected $hidden = ['textItems', 'imageItems', 'formItems', 'filesItems', 'genericItems', 'locationItems', 'faqItems', 'groupEventsItems', 'campItems', 'contactItems', 'blogPostsItems', 'password'];

    protected $appends = ['password_protected'];

    public function getItemForeignKey()
    {
        return 'page_id';
    }

    public function files()
    {
        return $this->belongsToMany(File::class, 'page_file');

    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'route' => $this->route,
        ];
    }



    public function getPasswordProtectedAttribute()
    {
        return ! empty($this->password);
    }
}
