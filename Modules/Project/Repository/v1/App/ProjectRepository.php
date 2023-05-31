<?php

namespace Modules\Project\Repository\v1\App;

use Modules\Project\Entities\Project;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class ProjectRepository implements ProjectRepositoryInterface
{
    public function find($id)
    {
        return Project::query()->where('id', $id)->first();
    }

    public function firstOrFail($id)
    {
        return Project::query()->where('id', $id)->firstOrFail();
    }

    public function show($id)
    {
        $project = $this->firstOrFail($id);
        return $project;
    }
}
