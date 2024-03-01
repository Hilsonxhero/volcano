<?php

namespace Modules\Project\Repository\Contracts;

interface BoardMemberRepository
{
    public function create($data);
    public function find($value, $condition = "id");
    public function update($data, $id);
    public function delete($id);
}
