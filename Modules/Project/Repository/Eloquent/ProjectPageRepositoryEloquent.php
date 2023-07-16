<?php

namespace Modules\Project\Repository\v1\App;


use Modules\Project\Entities\ProjectPage;
use Modules\Project\Repository\Contracts\ProjectPageRepository;

class ProjectPageRepositoryEloquent implements ProjectPageRepository
{

    public function get($id)
    {
        $pages = ProjectPage::query()->where('project_id', $id)->whereNull('parent_id')->orderByDesc('created_at')->get();
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

    public function update($data, $id)
    {
        $page = ProjectPage::query()->where('id', $id)->update($data);
        return $page;
    }

    public function delete($id)
    {
        $page = $this->find($id, 'id');
        $page->delete();
        return true;
    }
}
