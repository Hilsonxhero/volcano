<?php

namespace Modules\Page\Entities;

use Illuminate\Support\Str;
use Modules\Banner\Entities\Banner;
use Illuminate\Database\Eloquent\Model;
use Modules\Page\Database\factories\PageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'content', 'key',
    ];

    public static function booted()
    {
        static::saving(function ($page) {
            $page->slug = Str::slug($page->title, '-', null);
        });
    }

    protected static function newFactory()
    {
        return PageFactory::new();
    }
}
