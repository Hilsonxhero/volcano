<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectIssueStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'title',
        'description',
        'is_closed',
        'status',
    ];

    // protected static function newFactory()
    // {
    //     return \Modules\Project\Database\factories\ProjectIssueStatusFactory::new();
    // }
}
