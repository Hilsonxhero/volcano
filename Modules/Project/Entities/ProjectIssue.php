<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    ];

    // protected static function newFactory()
    // {
    //     return \Modules\Project\Database\factories\ProjectIssueFactory::new();
    // }
}
