<?php

namespace Modules\Project\Repository\Eloquent;

use Modules\Project\Entities\ProjectIssue;
use Modules\Project\Repository\Contracts\ProjectIssueRepository;


class ProjectIssueRepositoryEloquent implements ProjectIssueRepository
{

    public function all($project)
    {
        $query = ProjectIssue::orderBy('created_at', 'desc')->where('project_id', $project);
        $query->when(request()->has('q'), function ($query) {
            $searchTerm = "%" . request()->q . "%";
            $query->where(function ($query) use ($searchTerm) {
                $query->where('title', 'LIKE', $searchTerm);
            });
        });

        return $query->paginate();
    }

    public function get($project)
    {
        $issues = ProjectIssue::query()->where('project_id', $project)->orderByDesc('created_at')->get();
        return $issues;
    }
    public function select($project)
    {
        $issues = ProjectIssue::query()->where('project_id', $project)->orderByDesc('created_at')->take(25)->get();
        return $issues;
    }

    public function show($id)
    {
        $page = $this->find($id, 'id');
        return $page;
    }

    public function find($value, $condition = "id")
    {
        return ProjectIssue::query()->where($condition, $value)->first();
    }

    public function store($data)
    {
        if (request()->is_default) {
            ProjectIssue::query()->update(['is_default' => false]);
        }
        $page = ProjectIssue::query()->create($data);
        return $page;
    }

    public function update($data, $id)
    {
        if (request()->is_default) {
            ProjectIssue::query()->update(['is_default' => false]);
        }
        $page = ProjectIssue::query()->where('id', $id)->update($data);
        return $page;
    }

    public function delete($id)
    {
        $page = $this->find($id, 'id');
        $page->delete();
        return true;
    }
}
