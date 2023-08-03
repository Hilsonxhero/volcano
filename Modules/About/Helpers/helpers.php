<?php

use Modules\About\Repository\Contracts\AboutRepository;

if (!function_exists('aboutRepo')) {
    /**
     * Get the About repo.
     *
     * @return AboutRepository
     */
    function aboutRepo(): AboutRepository
    {
        return resolve(AboutRepository::class);
    }
}
