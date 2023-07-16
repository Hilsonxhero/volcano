<?php

namespace Modules\Project\Repository\Contracts;

interface ProjectPageRepository
{
    public function store($data);
    public function find($value, $field);
}
