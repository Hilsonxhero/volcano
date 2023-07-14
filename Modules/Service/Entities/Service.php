<?php

namespace Modules\Service\Entities;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Service extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        "title",
        "slug",
        "description",
        "status",
    ];

    protected static function newFactory()
    {
        return \Modules\Service\Database\factories\ServiceFactory::new();
    }

    public static function booted()
    {
        static::saving(function ($article) {
            $article->slug = Str::slug($article->title, '-', null);
        });
    }
}
