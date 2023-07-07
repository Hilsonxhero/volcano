<?php

use Modules\Setting\Repository\Contracts\SettingRepository;

if (!function_exists('settingRepo')) {
    /**
     * Get the Setting repo.
     *
     * @return SettingRepository
     */
    function settingRepo(): SettingRepository
    {
        return resolve(SettingRepository::class);
    }
}
