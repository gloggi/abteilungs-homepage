<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqItem extends Model
{
    use HasFactory;

    protected $fillable = ['faq_id', 'sort', 'page_id'];

    protected $appends = ['type'];

    public function getTypeAttribute()
    {
        return 'faqItem';
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function faq()
    {
        return $this->belongsTo(Faq::class);
    }
}
