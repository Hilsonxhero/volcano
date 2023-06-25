<?php

namespace Modules\RolePermissions\Repository\v1\App\Portal;

interface RoleRepositoryInterface
{
    public function store($data);
    public function find($value, $field);
}
