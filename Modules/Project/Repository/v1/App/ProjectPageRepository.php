<?php

namespace Modules\Project\Repository\v1\App;


use Modules\Project\Entities\ProjectPage;

class ProjectPageRepository implements ProjectPageRepositoryInterface
{

    public function get($id)
    {
        $pages = ProjectPage::query()->where('project_id', $id)->orderByDesc('created_at')->get();
        return $pages;
    }

    public function show($id)
    {
        $page = $this->find($id, 'id');
        return $page;
    }

    public function find($value, $condition = "id")
    {
        return ProjectPage::query()->where($condition, $value)->first();
    }

    public function store($data)
    {
        $page = ProjectPage::query()->create($data);
        return $page;
    }

    public function update($data)
    {
        $page = ProjectPage::query()->update($data);
        return $page;
    }
}
