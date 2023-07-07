<?php

namespace Modules\Setting\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Modules\Setting\Repository\Contracts\SettingRepository;
use Modules\Setting\Repository\Eloquent\SettingRepositoryEloquent;

class SettingRepoServiceProvider extends ServiceProvider
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
        $this->app->bind(SettingRepository::class, SettingRepositoryEloquent::class);
    }
}
