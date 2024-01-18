<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;

class Board extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "description",
        "short_link",
        "status",
        "user_id",
        "date_last_activity",
        "date_last_view",
        'project_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // protected static function newFactory()
    // {
    //     return \Modules\Project\Database\factories\BoardFactory::new();
    // }
}
