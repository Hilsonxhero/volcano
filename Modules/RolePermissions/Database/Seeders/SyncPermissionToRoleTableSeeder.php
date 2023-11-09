<?php

namespace Modules\RolePermissions\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\RolePermissions\Entities\Permission;
use Modules\RolePermissions\Entities\Role;
use Modules\RolePermissions\Fields\PermissionFields;
use Modules\RolePermissions\Fields\RoleFields;

class SyncPermissionToRoleTableSeeder extends Seeder
{

    protected array $rolePermission;
    protected array $portalRolePermission;
    public function __construct()
    {
        $this->rolePermission = config('rolepermissions.policy.permission_role');
        $this->portalRolePermission = config('rolepermissions.policy.portal_permission_role');
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        foreach ($this->rolePermission as $roleName => $permissionGroups) {
            // Get Role
            $role = Role::where(RoleFields::NAME, $roleName)->first();

            if ($role) {
                $permissionsQuery = Permission::query();

                if ($permissionGroups === ['*'])
                    $permissionsQuery->whereNull(PermissionFields::PARENT_ID);
                else
                    $permissionsQuery->whereIn(PermissionFields::NAME, $permissionGroups);

                $permissionsIds = $permissionsQuery->get()
                    ->flatMap(fn ($group) => $group->children()->pluck(PermissionFields::ID)->toArray());

                // Sync Permission Ids To Role
                $role->permissions()->sync($permissionsIds);
            }
        }
        foreach ($this->portalRolePermission as $roleName => $permissionGroups) {

            $role = Role::where(RoleFields::NAME, $roleName)->first();

            if ($role) {
                $permissionsQuery = Permission::query()->where('is_portal', true);

                if ($permissionGroups === ['*'])
                    $permissionsQuery->whereNull(PermissionFields::PARENT_ID);
                else
                    $permissionsQuery->whereIn(PermissionFields::NAME, $permissionGroups);

                $permissionsIds = $permissionsQuery->get()
                    ->flatMap(fn ($group) => $group->children()->pluck(PermissionFields::ID)->toArray());

                // Sync Permission Ids To Role
                $role->permissions()->sync($permissionsIds);
            }
        }
    }
}
