<?php

namespace Modules\Project\Repository\Eloquent;

use Modules\Project\Entities\ProjectTracker;
use Modules\Project\Repository\Contracts\ProjectTrackerRepository;

class ProjectTrackerRepositoryEloquent implements ProjectTrackerRepository
{

    public function all($project)
    {
        $query = ProjectTracker::orderBy('created_at', 'desc')->where('project_id', $project);
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
        $trackers = ProjectTracker::query()->where('project_id', $id)->orderByDesc('created_at')->get();
        return $trackers;
    }

    public function show($id)
    {
        $page = $this->find($id, 'id');
        return $page;
    }

    public function find($value, $condition = "id")
    {
        return ProjectTracker::query()->where($condition, $value)->first();
    }

    public function store($data)
    {
        if (request()->is_default) {
            ProjectTracker::query()->update(['is_default' => false]);
        }
        $page = ProjectTracker::query()->create($data);
        return $page;
    }

    public function insert($data)
    {
        $page = ProjectTracker::query()->insert($data);
        return $page;
    }

    public function update($data, $id)
    {
        if (request()->is_default) {
            ProjectTracker::query()->update(['is_default' => false]);
        }
        $page = ProjectTracker::query()->where('id', $id)->update($data);
        return $page;
    }

    public function delete($id)
    {
        $page = $this->find($id, 'id');
        $page->delete();
        return true;
    }
}
