<?php

namespace Modules\Project\Repository\Eloquent;

use Modules\Project\Entities\ProjectIssue;
use Modules\Project\Repository\Contracts\ProjectIssueRepository;


class ProjectIssueRepositoryEloquent implements ProjectIssueRepository
{

    public function all($project)
    {
        $query = ProjectIssue::orderBy('created_at', 'desc')->where('project_id', $project);
        $searchTerm = "%" . request()->q . "%";
        $query->when(request()->has('q'), function ($query) use ($searchTerm) {
            $query->where(function ($query) use ($searchTerm) {
                $query->where('title', 'LIKE', $searchTerm);
            });
        })->when(!is_null(request()->title), function ($query) {
            $query->where(function ($query) {
                $query->where('title', 'LIKE', "%" . request()->title . "%");
            });
        })->when(!is_null(request()->project_tracker_id), function ($query) {
            $query->whereHas('tracker', function ($query) {
                $query->where('id', request()->project_tracker_id);
            });
        })->when(!is_null(request()->project_issue_status_id), function ($query) {
            $query->whereHas('issue_status', function ($query) {
                $query->where('id', request()->project_issue_status_id);
            });
        })->when(!is_null(request()->project_priority_id), function ($query) {
            $query->whereHas('project_priority', function ($query) {
                $query->where('id', request()->project_priority_id);
            });
        })->when(!is_null(request()->start_date), function ($query) {
            $start_date_carbon = createDatetimeFromFormat(request()->start_date, "Y/m/d");
            $query->where(function ($query) use ($start_date_carbon) {
                $query->whereDate('start_date', '>=', $start_date_carbon);
            });
        })->when(!is_null(request()->end_date), function ($query) {
            $end_date_carbon = createDatetimeFromFormat(request()->end_date, "Y/m/d");
            $query->where(function ($query) use ($end_date_carbon) {
                $query->whereDate('end_date', '<=', $end_date_carbon);
            });
        })->when(!is_null(request()->assigned), function ($query) {
            $query->whereHas('assigned', function ($query) {
                $query->where('id', request()->assigned);
            });
        });

        return $query->paginate();
    }

    public function get($project)
    {
        $issues = ProjectIssue::query()->where('project_id', $project)->orderByDesc('created_at')->get();
        return $issues;
    }

    public function children($id)
    {
        $issues = $this->find($id);
        return $issues->children()->paginate(10);
    }

    public function select($project)
    {
        $query = ProjectIssue::orderBy('created_at', 'desc');
        $query->when(request()->has('q'), function ($query) {
            $searchTerm = "%" . request()->q . "%";
            $query->where(function ($query) use ($searchTerm) {
                $query->where('title', 'LIKE', $searchTerm)
                    ->orWhere('description', 'LIKE', $searchTerm);
            })
                ->orWhereHas('parent', function ($query) use ($searchTerm) {
                    $query->where('title', 'LIKE', $searchTerm)
                        ->orWhere('description', 'LIKE', $searchTerm);;
                });
        });

        return $query->take(25)->get();
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
        $issue = $this->find($id, 'id');
        $issue->update($data);
        return $issue;
    }

    public function delete($id)
    {
        $page = $this->find($id, 'id');
        $page->delete();
        return true;
    }
}
