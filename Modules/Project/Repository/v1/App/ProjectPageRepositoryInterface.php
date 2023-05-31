<?php

namespace Modules\Project\Repository\v1\App;

interface ProjectPageRepositoryInterface
{
    public function store($data);
    public function find($value, $field);
}
