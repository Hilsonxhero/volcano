<?php

namespace Modules\RolePermissions\Providers;


use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Modules\RolePermissions\Repository\Contracts\PermissionRepository;
use Modules\RolePermissions\Repository\Contracts\RoleRepository;
use Modules\RolePermissions\Repository\Eloquent\PermissionRepositoryEloquent;
use Modules\RolePermissions\Repository\Eloquent\RoleRepositoryEloquent;

class RolePermissionsRepoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(RoleRepository::class, RoleRepositoryEloquent::class);
        $this->app->bind(PermissionRepository::class, PermissionRepositoryEloquent::class);
    }
}
