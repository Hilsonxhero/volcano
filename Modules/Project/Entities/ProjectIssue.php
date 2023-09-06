<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\User\Entities\User;

class ProjectIssue extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id',
        'project_issue_statuse_id',
        'project_tracker_id',
        'creator_id',
        'assigned_to_id',
        'title',
        'description',
        'note',
        'start_date',
        'end_date',
        'estimated_hours',
        'done_ratio',
        'status',
        'project_priority_id',
        'parent_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
    public function tracker()
    {
        return $this->belongsTo(ProjectTracker::class);
    }
    public function issue_status()
    {
        return $this->belongsTo(ProjectIssueStatus::class);
    }
    public function creator()
    {
        return $this->belongsTo(User::class);
    }
    public function assigned()
    {
        return $this->belongsTo(User::class);
    }
    public function parent()
    {
        return $this->belongsTo(ProjectIssue::class);
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function project_priority()
    {
        return $this->belongsTo(ProjectPriority::class);
    }

    // protected static function newFactory()
    // {
    //     return \Modules\Project\Database\factories\ProjectIssueFactory::new();
    // }
}
