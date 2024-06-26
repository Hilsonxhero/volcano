<?php

namespace Modules\Project\Entities;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Meta\Traits\Metable;
use Modules\Project\Casts\ProjectStatus;
use Modules\User\Entities\User;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Project extends Model  implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, Metable;

    protected $fillable = [
        'title', 'slug', 'short_link', 'description', 'user_id',
        'date_last_activity', 'date_last_view', 'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_last_activity' => 'datetime',
        'date_last_view' => 'datetime',
    ];

    protected static function newFactory()
    {
        return \Modules\Project\Database\factories\ProjectFactory::new();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300);
    }

    public static function booted()
    {
        static::creating(function ($project) {
            $project->short_link = Str::random(8);
            $project->slug = Str::slug($project->title, '-', null);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function members()
    // {
    //     return $this->belongsToMany(User::class, ProjectMembership::class);
    // }
    public function members()
    {
        return $this->hasMany(ProjectMembership::class);
    }

    public function boards()
    {
        return $this->hasMany(Board::class);
    }

    public function pages()
    {
        return $this->hasMany(ProjectPage::class)
            ->whereNull('parent_id')
            ->with(['children']);
    }
}
