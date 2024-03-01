<?php

namespace Modules\Project\Repository\Contracts;

interface BoardRepository
{
    public function store($data);
    public function find($value, $condition = "id");
}
