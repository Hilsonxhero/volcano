<?php

namespace Modules\Project\Entities;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'project_id',
        'parent_id',
        'status',
    ];

    protected static function newFactory()
    {
        return \Modules\Project\Database\factories\ProjectPageFactory::new();
    }


    public static function booted()
    {
        static::creating(function ($project) {
            $project->slug = Str::slug($project->title, '-', null);
        });
    }

    public function parent()
    {
        return $this->belongsTo(ProjectPage::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
