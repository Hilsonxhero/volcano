<?php

namespace Modules\Project\Repository\Contracts;

interface ProjectTimeCategoryRepository
{
    public function store($data);
    public function find($value, $field);
}
