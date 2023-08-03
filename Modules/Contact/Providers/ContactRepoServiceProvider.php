<?php

namespace Modules\Contact\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Modules\Contact\Repository\Contracts\ContactMessageRepository;
use Modules\Contact\Repository\Eloquent\ContactMessageRepositoryEloquent;

class ContactRepoServiceProvider extends ServiceProvider
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
        $this->app->bind(ContactMessageRepository::class, ContactMessageRepositoryEloquent::class);
    }
}
