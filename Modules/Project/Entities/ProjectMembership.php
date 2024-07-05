<?php

namespace Modules\Project\Entities;

use Modules\User\Entities\User;
use Modules\Project\Entities\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\RolePermissions\Entities\Role;

class ProjectMembership extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'user_id', 'project_id', 'status', "role_id"
    ];

    // protected static function newFactory()
    // {
    //     return \Modules\Project\Database\factories\ProjectMembershipFactory::new();
    // }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
