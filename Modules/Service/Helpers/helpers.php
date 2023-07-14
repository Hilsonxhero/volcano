<?php

use Modules\Service\Repository\Contracts\ServiceRepository;


if (!function_exists('serviceRepo')) {
    /**
     * Get the Service repo.
     *
     * @return ServiceRepository
     */
    function serviceRepo(): ServiceRepository
    {
        return resolve(ServiceRepository::class);
    }
}
