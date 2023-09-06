<?php

namespace Modules\Project\Repository\Contracts;

interface ProjectPriorityRepository
{
    public function store($data);
    public function find($value, $field);
}
