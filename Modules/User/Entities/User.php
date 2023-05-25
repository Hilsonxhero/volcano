<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Project\Entities\Project;
use Modules\Project\Entities\ProjectMembership;

class User extends Authenticatable
{
    use HasFactory, HasRoles, SoftDeletes, HasApiTokens;

    protected $fillable = [
        'username', 'ip', 'nullable', 'email', 'phone', 'email_verified_at',
        'remember_token', 'password', 'status', 'job', 'gender', 'is_superuser',
    ];

    protected static function newFactory()
    {
        return \Modules\User\Database\factories\UserFactory::new();
    }


    public function projects()
    {
        return $this->hasMany(Project::class);
    }
    public function memberships()
    {
        return $this->hasMany(ProjectMembership::class);
    }
}
