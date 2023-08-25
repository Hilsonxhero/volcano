<?php

namespace Modules\Project\Repository\Contracts;

interface ProjectTrackerRepository
{
    public function store($data);
    public function find($value, $field);
}
