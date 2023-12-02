<?php

namespace Modules\Project\Repository\Contracts;

interface ProjectTimeEntryRepository
{
    public function store($data);
    public function find($value, $field);
}
