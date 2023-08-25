<?php

namespace Modules\Project\Entities;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectTracker extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "project_id",
        "title",
        "slug",
        "description",
        "status",
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public static function booted()
    {
        static::saving(function ($item) {
            $item->slug = Str::slug($item->title, '-', null);
        });
    }

    // protected static function newFactory()
    // {
    //     return \Modules\Project\Database\factories\ProjectTrackerFactory::new();
    // }
}
