<?php

namespace Modules\Project\Repository\Eloquent;


use Modules\Project\Entities\ProjectPage;
use Modules\Project\Entities\ProjectTimeCategory;
use Modules\Project\Repository\Contracts\ProjectTimeCategoryRepository;

class ProjectTimeCategoryRepositoryEloquent implements ProjectTimeCategoryRepository
{

    public function all($project)
    {
        $query = ProjectTimeCategory::orderBy('created_at', 'desc')->where('project_id', $project);
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
        $pages = ProjectTimeCategory::query()->where('project_id', $id)->whereNull('parent_id')->orderByDesc('created_at')->get();
        return $pages;
    }

    public function show($id)
    {
        $page = $this->find($id, 'id');
        return $page;
    }

    public function find($value, $condition = "id")
    {
        return ProjectTimeCategory::query()->where($condition, $value)->first();
    }

    public function store($data)
    {
        if (request()->is_default) {
            ProjectTimeCategory::query()->update(['is_default' => false]);
        }
        $page = ProjectTimeCategory::query()->create($data);
        return $page;
    }

    public function insert($data)
    {
        $page = ProjectTimeCategory::query()->insert($data);
        return $page;
    }

    public function update($data, $id)
    {
        if (request()->is_default) {
            ProjectTimeCategory::query()->update(['is_default' => false]);
        }
        $page = ProjectTimeCategory::query()->where('id', $id)->update($data);
        return $page;
    }

    public function delete($id)
    {
        $page = $this->find($id, 'id');
        $page->delete();
        return true;
    }
}
