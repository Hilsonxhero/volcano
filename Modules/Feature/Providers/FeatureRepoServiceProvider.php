<?php

namespace Modules\Feature\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Modules\Feature\Repository\Contracts\FeatureRepository;
use Modules\Feature\Repository\Eloquent\FeatureRepositoryEloquent;

class FeatureRepoServiceProvider extends ServiceProvider
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
        $this->app->bind(FeatureRepository::class, FeatureRepositoryEloquent::class);
    }
}
