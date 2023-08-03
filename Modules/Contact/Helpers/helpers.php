<?php

use Modules\Contact\Repository\Contracts\ContactMessageRepository;

if (!function_exists('contactMessageRepo')) {
    /**
     * Get the ContactMessage repo.
     *
     * @return ContactMessageRepository
     */
    function contactMessageRepo(): ContactMessageRepository
    {
        return resolve(ContactMessageRepository::class);
    }
}
