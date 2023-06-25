<?php

namespace Modules\RolePermissions\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\RolePermissions\Traits\HasCustomRolePermission;

class Permission extends \Spatie\Permission\Models\Permission
{
    use HasFactory, HasCustomRolePermission;

    protected $fillable = [];

    // protected static function newFactory()
    // {
    //     return \Modules\RolePermissions\Database\factories\PermissionFactory::new();
    // }
}
