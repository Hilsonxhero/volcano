<?php

namespace Modules\RolePermissions\Providers;


use Modules\RolePermissions\Repository\v1\App\Portal\RoleRepository;
use Modules\RolePermissions\Repository\v1\App\Portal\RoleRepositoryInterface;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;


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
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
    }
}
