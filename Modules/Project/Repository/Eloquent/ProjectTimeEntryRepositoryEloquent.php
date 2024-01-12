<?php

namespace Modules\Project\Repository\Eloquent;

use Modules\Project\Entities\ProjectTimeEntry;
use Modules\Project\Repository\Contracts\ProjectTimeEntryRepository;

class ProjectTimeEntryRepositoryEloquent implements ProjectTimeEntryRepository
{

    public function all($project)
    {
        $query = ProjectTimeEntry::orderBy('created_at', 'desc')->where('project_id', $project);
        $query->when(request()->has('q'), function ($query) {
            $searchTerm = "%" . request()->q . "%";
            $query->where(function ($query) use ($searchTerm) {
                $query->where('title', 'LIKE', $searchTerm);
            });
        });

        return $query->paginate();
    }

    public function get($id)
    {
        $times = ProjectTimeEntry::query()->where('project_id', $id)->whereNull('parent_id')->orderByDesc('created_at')->get();
        return $times;
    }

    public function show($id)
    {
        $time = $this->find($id, 'id');
        return $time;
    }

    public function find($value, $condition = "id")
    {
        return ProjectTimeEntry::query()->where($condition, $value)->first();
    }

    public function store($data)
    {
        $time = ProjectTimeEntry::query()->create($data);
        return $time;
    }

    public function update($data, $id)
    {
        if (request()->is_default) {
            ProjectTimeEntry::query()->update(['is_default' => false]);
        }
        $time = ProjectTimeEntry::query()->where('id', $id)->update($data);
        return $time;
    }

    public function delete($id)
    {
        $time = $this->find($id, 'id');
        $time->delete();
        return true;
    }

    public function getReport($product, $user)
    {
    }
}
