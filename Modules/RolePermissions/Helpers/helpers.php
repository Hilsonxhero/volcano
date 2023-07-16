<?php

use Modules\RolePermissions\Repository\Contracts\PermissionRepository;
use Modules\RolePermissions\Repository\Contracts\RoleRepository;


if (!function_exists('roleRepo')) {
    /**
     * Get the Role repo.
     *
     * @return RoleRepository
     */
    function roleRepo(): RoleRepository
    {
        return resolve(RoleRepository::class);
    }
}

if (!function_exists('permissionRepo')) {
    /**
     * Get the Permission repo.
     *
     * @return PermissionRepository
     */
    function permissionRepo(): PermissionRepository
    {
        return resolve(PermissionRepository::class);
    }
}
