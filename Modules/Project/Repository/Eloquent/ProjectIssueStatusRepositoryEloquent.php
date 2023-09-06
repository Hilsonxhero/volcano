<?php

namespace Modules\Project\Repository\Eloquent;

use Modules\Project\Entities\ProjectIssueStatus;
use Modules\Project\Repository\Contracts\ProjectIssueStatusRepository;


class ProjectIssueStatusRepositoryEloquent implements ProjectIssueStatusRepository
{

    public function all($project)
    {
        $query = ProjectIssueStatus::orderBy('created_at', 'desc')->where('project_id', $project);
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
        $pages = ProjectIssueStatus::query()->where('project_id', $id)->orderByDesc('created_at')->get();
        return $pages;
    }

    public function show($id)
    {
        $page = $this->find($id, 'id');
        return $page;
    }

    public function find($value, $condition = "id")
    {
        return ProjectIssueStatus::query()->where($condition, $value)->first();
    }

    public function store($data)
    {
        if (request()->is_default) {
            ProjectIssueStatus::query()->update(['is_default' => false]);
        }
        $page = ProjectIssueStatus::query()->create($data);
        return $page;
    }

    public function update($data, $id)
    {
        if (request()->is_default) {
            ProjectIssueStatus::query()->update(['is_default' => false]);
        }
        $page = ProjectIssueStatus::query()->where('id', $id)->update($data);
        return $page;
    }

    public function delete($id)
    {
        $page = $this->find($id, 'id');
        $page->delete();
        return true;
    }
}
