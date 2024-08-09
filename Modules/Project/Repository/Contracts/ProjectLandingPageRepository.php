<?php

namespace Modules\Project\Repository\Contracts;

interface ProjectLandingPageRepository
{
    public function store($data);
    public function find($value, $field);
}
