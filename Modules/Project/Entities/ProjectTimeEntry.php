<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\User\Entities\User;

class ProjectTimeEntry extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id',
        'project_issue_id',
        'project_time_category_id',
        'user_id',
        'title',
        'description',
        'spent_on',
        'hours',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function issue()
    {
        return $this->belongsTo(ProjectIssue::class, 'project_issue_id', 'id');
    }
    public function category()
    {
        return $this->belongsTo(ProjectTimeCategory::class, 'project_time_category_id', 'id');
    }
}
