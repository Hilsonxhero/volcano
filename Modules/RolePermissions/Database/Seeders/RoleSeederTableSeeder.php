<?php

namespace Modules\RolePermissions\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\RolePermissions\Entities\Role;
use Modules\RolePermissions\Fields\RoleFields;

class RoleSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get permissions for the module
        $roles = config('rolepermissions.policy.role');

        if ($roles) {
            // Create permissions for each module
            foreach ($roles as $parentName => $children) {
                // Create Parent
                $parentRole = Role::create([
                    RoleFields::NAME       => $parentName,
                    RoleFields::TITLE      => __("rolepermissions::policy.role.$parentName.parent"),
                    RoleFields::GUARD_NAME => 'api',
                ]);
                // Create Children
                foreach ($children as $roleName) {
                    $parentRole->children()->create([
                        RoleFields::NAME       => "{$roleName}",
                        RoleFields::TITLE      => __("rolepermissions::policy.role.$parentName.$roleName"),
                        RoleFields::PARENT_ID  => $parentRole->id,
                        RoleFields::GUARD_NAME => 'api',
                    ]);
                }
            }
        }
    }
}
