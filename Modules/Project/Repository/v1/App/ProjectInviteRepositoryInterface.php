<?php

namespace Modules\Project\Repository\v1\App;

interface ProjectInviteRepositoryInterface
{
    public function store($data);
    public function find($value, $field);
}
