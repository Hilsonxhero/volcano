<?php

namespace Modules\About\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Modules\About\Repository\Contracts\AboutRepository;
use Modules\About\Repository\Eloquent\AboutRepositoryEloquent;

class AboutRepoServiceProvider extends ServiceProvider
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
        $this->app->bind(AboutRepository::class, AboutRepositoryEloquent::class);
    }
}
