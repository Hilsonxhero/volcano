<?php

use Modules\Article\Repository\Contracts\ArticleRepository;

if (!function_exists('articleRepo')) {
    /**
     * Get the Article repo.
     *
     * @return ArticleRepository
     */
    function articleRepo(): ArticleRepository
    {
        return resolve(ArticleRepository::class);
    }
}
