<?php

namespace Modules\Feature\Entities;

use Illuminate\Support\Str;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class Feature extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'status',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300)
            ->format(Manipulations::FORMAT_PNG);
    }
    public static function booted()
    {
        static::saving(function ($feature) {
            $feature->slug = Str::slug($feature->title, '-', null);
        });
    }


    // protected static function newFactory()
    // {
    //     return \Modules\Feature\Database\factories\FeatureFactory::new();
    // }
}
