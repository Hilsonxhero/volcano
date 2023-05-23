<?php

namespace Modules\User\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Modules\User\Repository\v1\Profile\UserProjectRepository;
use Modules\User\Repository\v1\Profile\UserProjectRepositoryInterface;

class UserRepoServiceProvider extends ServiceProvider
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
        $this->app->bind(UserProjectRepositoryInterface::class, UserProjectRepository::class);
    }
}
