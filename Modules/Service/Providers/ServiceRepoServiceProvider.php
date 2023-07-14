<?php

namespace Modules\Service\Providers;


use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Modules\Service\Repository\Contracts\ServiceRepository;
use Modules\User\Repository\Eloquent\ServiceRepositoryEloquent;

class ServiceRepoServiceProvider extends ServiceProvider
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
        $this->app->bind(ServiceRepository::class, ServiceRepositoryEloquent::class);
    }
}
