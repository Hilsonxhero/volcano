<?php

namespace Modules\Project\Entities;

use Illuminate\Support\Str;
use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    public function members()
    {
        return $this->hasMany(BoardMember::class);
    }
    // protected static function newFactory()
    // {
    //     return \Modules\Project\Database\factories\BoardFactory::new();
    // }


    public static function booted()
    {
        static::creating(function ($board) {
            $board->short_link = Str::random(8);
        });
    }
}
