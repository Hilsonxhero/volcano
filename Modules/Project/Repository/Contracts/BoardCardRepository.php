<?php

namespace Modules\Project\Repository\Contracts;

interface BoardCardRepository
{
    public function store($data);
    public function find($value, $condition = "id");
    public function update($data, $id);
}
