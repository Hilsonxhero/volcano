<?php

namespace Modules\Project\Repository\Contracts;

interface BoardListRepository
{
    public function store($data);
    public function find($value, $field);
}
