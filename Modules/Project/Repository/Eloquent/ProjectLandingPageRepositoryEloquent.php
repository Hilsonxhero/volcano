<?php

namespace Modules\Project\Repository\Eloquent;

use Modules\Project\Entities\ProjectLandingPage;
use Modules\Project\Repository\Contracts\ProjectLandingPageRepository;

class ProjectLandingPageRepositoryEloquent implements ProjectLandingPageRepository
{

    public function all($project)
    {
        $query = ProjectLandingPage::orderBy('created_at', 'desc')->where('project_id', $project);
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
        $pages = ProjectLandingPage::query()->where('project_id', $id)->orderByDesc('created_at')->get();
        return $pages;
    }

    public function children($id)
    {
        $item = $this->find($id, 'id');
        return $item->children()->paginate();
    }

    public function show($id)
    {
        $page = $this->find($id, 'id');
        return $page;
    }

    public function find($value, $condition = "id")
    {
        return ProjectLandingPage::query()->where($condition, $value)->first();
    }

    public function store($data)
    {
        $page = ProjectLandingPage::query()->create($data);
        return $page;
    }

    public function update($data, $id)
    {
        $page = ProjectLandingPage::query()->where('id', $id)->update($data);
        return $page;
    }

    public function delete($id)
    {
        $page = $this->find($id, 'id');
        $page->delete();
        return true;
    }
}
