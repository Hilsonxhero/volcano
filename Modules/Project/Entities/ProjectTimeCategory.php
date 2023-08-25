<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectTimeCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id',
        'title',
        'is_default',
        'status',
    ];

    // protected static function newFactory()
    // {
    //     return \Modules\Project\Database\factories\ProjectTimeCategoryFactory::new();
    // }
}
