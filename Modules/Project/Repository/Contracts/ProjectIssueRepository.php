<?php

namespace Modules\Project\Repository\Contracts;

interface ProjectIssueRepository
{
    public function store($data);
    public function find($value, $field);
}
