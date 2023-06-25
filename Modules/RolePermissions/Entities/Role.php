<?php

namespace Modules\RolePermissions\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\RolePermissions\Traits\HasCustomRolePermission;

class Role extends  \Spatie\Permission\Models\Role
{
    use HasFactory, HasCustomRolePermission;

    protected $fillable = [];

    // protected static function newFactory()
    // {
    //     return \Modules\RolePermissions\Database\factories\RoleFactory::new();
    // }
}
