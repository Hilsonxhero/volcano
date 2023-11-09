<?php

namespace Modules\Project\Repository\Eloquent;

use Modules\Project\Entities\Project;
use Modules\Project\Repository\Contracts\ProjectRepository;

class ProjectRepositoryEloquent implements ProjectRepository
{

    public function all()
    {
        $query = project::orderBy('created_at', 'desc')->withCount('members');
        $query->when(request()->has('q'), function ($query) {
            $searchTerm = "%" . request()->q . "%";
            $query->where(function ($query) use ($searchTerm) {
                $query->where('title', 'LIKE', $searchTerm)
                    ->orWhere('description', 'LIKE', $searchTerm);
            });
        });

        return $query->paginate();
    }

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

    public function update($id, $data)
    {
        $project = $this->find($id);
        $project->update($data);
        return $project;
    }
}
