<?php

namespace Modules\About\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class About extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'value',
    ];
    protected $table = "about_page";
    public $timestamps = false;

    // protected static function newFactory()
    // {
    //     return \Modules\About\Database\factories\AboutFactory::new();
    // }
}
