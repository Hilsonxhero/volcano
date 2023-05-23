<?php

namespace Modules\User\Repository\v1\Profile;

interface UserProjectRepositoryInterface
{
    public function get();
    public function store($data);
}
