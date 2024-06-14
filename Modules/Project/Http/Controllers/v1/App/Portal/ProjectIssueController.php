<?php

namespace Modules\Project\Http\Controllers\v1\App\Portal;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Modules\Project\Entities\Project;
use Modules\Common\Services\ApiService;
use Modules\Project\Enums\ProjectIssueStatus;
use Modules\Project\Jobs\SendResponsibleNotif;
use Modules\Project\Entities\ProjectMembership;
use Modules\Project\Http\Requests\v1\App\ProjectIssueRequest;
use Modules\Project\Transformers\v1\App\Portal\ProjectIssueResource;
use Modules\Project\Transformers\v1\App\Portal\ProjectIssueSelectResource;

class ProjectIssueController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, $id)
    {
        $this->authorize('manage', [Project::class, $id]);
        $issues = projectIssueRepo()->all($id);
        $issues_collection = ProjectIssueResource::collection($issues);
        ApiService::_success(
            array(
                'issues' => $issues_collection,
                'pager' => array(
                    'pages' => $issues_collection->lastPage(),
                    'total' => $issues_collection->total(),
                    'current_page' => $issues_collection->currentPage(),
                    'per_page' => $issues_collection->perPage(),
                )
            )
        );
    }

    public function select(Request $request, $id)
    {
        $this->authorize('manage', [Project::class, $id]);

        $issues = projectIssueRepo()->select($id);
        $issues_collection = ProjectIssueSelectResource::collection($issues);
        ApiService::_success($issues_collection);
    }

    public function children(Request $request, $project, $id)
    {
        $issues = projectIssueRepo()->children($id);
        $issues_collection = ProjectIssueResource::collection($issues);
        ApiService::_success(
            array(
                'children' => $issues_collection,
                'pager' => array(
                    'pages' => $issues_collection->lastPage(),
                    'total' => $issues_collection->total(),
                    'current_page' => $issues_collection->currentPage(),
                    'per_page' => $issues_collection->perPage(),
                )
            )
        );
    }



    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(ProjectIssueRequest $request)
    {
        $this->authorize('manage', [Project::class, $request->input('project_id')]);

        $user = auth()->user();
        $assigned_user = projectMembershipRepo()->find($request->assigned_to_id);
        $data = array(
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'note' => $request->input('note'),
            'project_id' => $request->input('project_id'),
            'project_tracker_id' => $request->input('project_tracker_id'),
            'project_issue_status_id' => $request->input('project_issue_status_id'),
            'assigned_to_id' => $assigned_user->user_id,
            'project_priority_id' => $request->input('project_priority_id'),
            'start_date' => $request->input('start_date') ?  createDatetimeFromFormat($request->start_date) : null,
            'end_date' => $request->input('end_date') ?  createDatetimeFromFormat($request->end_date) : null,
            'estimated_hours' => $request->input('estimated_hours'),
            'done_ratio' => $request->input('done_ratio'),
            'creator_id' => $user->id,
            'parent_id' => $request->input('parent_id'),
            'status' => ProjectIssueStatus::ACTIVE->value
        );
        $issue = projectIssueRepo()->store($data);

        if ($request->attachments) {
            foreach ($request->attachments as $key => $attachment) {
                $issue->addMedia($attachment)->toMediaCollection();
            }
        }

        SendResponsibleNotif::dispatch($assigned_user->user->phone, $issue);
        ApiService::_success(trans('response.responses.200'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($project, $id)
    {
        $this->authorize('manage', [Project::class, $project]);

        $issue = projectIssueRepo()->show($id);
        $resource = new ProjectIssueResource($issue);
        ApiService::_success($resource);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(ProjectIssueRequest $request, $project, $id)
    {
        $this->authorize('manage', [Project::class, $project]);

        $user = auth()->user();
        $data = array(
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'note' => $request->input('note'),
            'project_id' => $request->input('project_id'),
            'project_tracker_id' => $request->input('project_tracker_id'),
            'project_issue_status_id' => $request->input('project_issue_status_id'),
            'assigned_to_id' => $request->input('assigned_to_id'),
            'project_priority_id' => $request->input('project_priority_id'),
            'start_date' => $request->input('start_date') ?  createDatetimeFromFormat($request->start_date) : null,
            'end_date' => $request->input('end_date') ?  createDatetimeFromFormat($request->end_date) : null,
            'estimated_hours' => $request->input('estimated_hours'),
            'done_ratio' => $request->input('done_ratio'),
            'parent_id' => $request->input('parent_id'),
            'status' => ProjectIssueStatus::ACTIVE->value
        );
        $issue = projectIssueRepo()->update($data, $id);
        if ($request->attachments) {
            foreach ($request->attachments as $key => $attachment) {
                $issue->addMedia($attachment)->toMediaCollection();
            }
        }
        $assigned_user = projectMembershipRepo()->find($request->assigned_to_id);
        SendResponsibleNotif::dispatch($assigned_user->user->email, $issue);
        ApiService::_success(trans('response.responses.200'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($project, $id)
    {
        $this->authorize('manage', [Project::class, $project]);

        $issue = projectIssueRepo()->delete($id);
        ApiService::_success(trans('response.responses.200'));
    }
}
