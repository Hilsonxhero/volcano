<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    // protected static function newFactory()
    // {
    //     return \Modules\Project\Database\factories\ProjectTimeEntryFactory::new();
    // }
}
