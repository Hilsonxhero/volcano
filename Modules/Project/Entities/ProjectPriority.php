<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectPriority extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    // protected static function newFactory()
    // {
    //     return \Modules\Project\Database\factories\ProjectPriorityFactory::new();
    // }
}
