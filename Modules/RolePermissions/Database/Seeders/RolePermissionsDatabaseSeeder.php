<?php

namespace Modules\RolePermissions\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RolePermissionsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Model::unguard();
        $this->call([
            PermissionTableSeeder::class,
            RoleSeederTableSeeder::class,
            SyncPermissionToRoleTableSeeder::class,
        ]);
    }
}
