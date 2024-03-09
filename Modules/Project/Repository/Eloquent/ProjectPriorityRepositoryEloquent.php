<?php

namespace Modules\Project\Repository\Eloquent;


use Modules\Project\Entities\ProjectPage;
use Modules\Project\Entities\ProjectPriority;
use Modules\Project\Repository\Contracts\ProjectPriorityRepository;

class ProjectPriorityRepositoryEloquent implements ProjectPriorityRepository
{

    public function all()
    {
        $query = ProjectPriority::orderBy('created_at', 'desc');
        $query->when(request()->has('q'), function ($query) {
            $searchTerm = "%" . request()->q . "%";
            $query->where(function ($query) use ($searchTerm) {
                $query->where('title', 'LIKE', $searchTerm);
            });
        });

        return $query->paginate();
    }

    public function get()
    {
        $pages = ProjectPriority::query()->orderByDesc('created_at')->get();
        return $pages;
    }

    public function show($id)
    {
        $page = $this->find($id, 'id');
        return $page;
    }

    public function find($value, $condition = "id")
    {
        return ProjectPriority::query()->where($condition, $value)->first();
    }

    public function store($data)
    {
        $page = ProjectPriority::query()->create($data);
        return $page;
    }

    public function insert($data)
    {
        $page = ProjectPriority::query()->insert($data);
        return $page;
    }

    public function update($data, $id)
    {
        $page = ProjectPriority::query()->where('id', $id)->update($data);
        return $page;
    }

    public function delete($id)
    {
        $page = $this->find($id, 'id');
        $page->delete();
        return true;
    }
}
