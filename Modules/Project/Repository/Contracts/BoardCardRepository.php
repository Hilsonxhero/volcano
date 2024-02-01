<?php

namespace Modules\Project\Repository\Contracts;

interface BoardCardRepository
{
    public function store($data);
    public function find($value, $field);
}
