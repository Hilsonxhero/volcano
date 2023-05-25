<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;

class ProjectInvite extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'email',
        'token',
        'deactivated',
        'confirmed',
    ];

    // protected static function newFactory()
    // {
    //     return \Modules\Project\Database\factories\ProjectInviteFactory::new();
    // }

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
