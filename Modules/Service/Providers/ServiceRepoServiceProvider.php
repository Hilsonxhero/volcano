<?php

namespace Modules\Service\Providers;


use Modules\Service\Repository\Contracts\ServiceRepository;
use Modules\Service\Repository\Eloquent\ServiceRepositoryEloquent;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

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
