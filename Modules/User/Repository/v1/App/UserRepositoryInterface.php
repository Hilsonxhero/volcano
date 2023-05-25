<?php

namespace Modules\User\Repository\v1\App;

interface UserRepositoryInterface
{
    public function find($value, $field);
}
