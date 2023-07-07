<?php

namespace Modules\Project\Repository\v1\App;

use Modules\Project\Entities\Project;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class ProjectRepository implements ProjectRepositoryInterface
{
    public function find($value, $condition = "id", $relationships = null)
    {
        $query = Project::query();
        $query->where($condition, $value);
        if ($relationships) {
            $query->with($relationships);
        }
        return $query->first();
    }

    public function members($id)
    {
        $project = $this->find($id, "id", ["members"]);
        return $project->members()->orderByDesc('created_at')->paginate();
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

    public function create($data)
    {
        return Project::query()->create($data);
    }
}
