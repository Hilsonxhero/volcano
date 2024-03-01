<?php

namespace Modules\User\Repository\Contracts;

interface UserRepository
{
    public function find($value, $condition = "id");
}
