<?php

namespace Modules\Service\Entities;

use Illuminate\Support\Str;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Service extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        "title",
        "is_promotion",
        "slug",
        "description",
        "status",
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300)
            ->format(Manipulations::FORMAT_PNG);
    }

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
