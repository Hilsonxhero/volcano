<?php

namespace Modules\Project\Repository\Contracts;

interface ProjectIssueStatusRepository
{
    public function store($data);
    public function find($value, $field);
}
