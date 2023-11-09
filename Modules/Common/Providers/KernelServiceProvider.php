<?php

namespace Modules\Common\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Common\Exceptions\ApiExceptionHandler;

class KernelServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerException();
    }

    /**
     * Register the exceptions.
     *
     * @return void
     */
    private function registerException(): void
    {
        $this->app->singleton(
            \Illuminate\Contracts\Debug\ExceptionHandler::class,
            ApiExceptionHandler::class
        );
    }
}
