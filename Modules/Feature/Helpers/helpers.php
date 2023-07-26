<?php

use Modules\Feature\Repository\Contracts\FeatureRepository;


if (!function_exists('featureRepo')) {
    /**
     * Get the Feature repo.
     *
     * @return FeatureRepository
     */
    function featureRepo(): FeatureRepository
    {
        return resolve(FeatureRepository::class);
    }
}
