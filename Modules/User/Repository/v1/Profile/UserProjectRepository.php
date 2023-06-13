<?php

namespace Modules\User\Repository\v1\Profile;

use Modules\Project\Entities\Project;

class UserProjectRepository implements UserProjectRepositoryInterface
{

    public function get()
    {
        $user = auth()->user();
        return $user->projects()->OrderByDesc('created_at')->get();
    }

    public function find($value, $condition = "id")
    {
        return Project::query()->where($condition, $value)->first();
    }

    public function show($id)
    {
        $project = $this->find($id, 'id');
        return $project;
    }

    public function store($data)
    {
        return Project::query()->create($data);
    }
}
