<?php

namespace Modules\Project\Http\Controllers\v1\App\Portal;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\Project\Enums\ProjectIssueStatus;
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
        $issues = projectIssueRepo()->select($id);
        $issues_collection = ProjectIssueSelectResource::collection($issues);
        ApiService::_success($issues_collection);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(ProjectIssueRequest $request)
    {
        $user = auth()->user();
        $data = array(
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'note' => $request->input('note'),
            'project_id' => $request->input('project_id'),
            'project_tracker_id' => $request->input('project_tracker_id'),
            'project_issue_statuse_id' => $request->input('project_issue_statuse_id'),
            'assigned_to_id' => $request->input('assigned_to_id'),
            'priority_id' => $request->input('priority_id'),
            'start_date' => $request->input('start_date') ?  createDatetimeFromFormat($request->start_date, "Y/m/d") : null,
            'end_date' => $request->input('end_date') ?  createDatetimeFromFormat($request->end_date, "Y/m/d") : null,
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
        ApiService::_success(trans('response.responses.200'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($prokect, $id)
    {
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
        $user = auth()->user();
        $data = array(
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'note' => $request->input('note'),
            'project_id' => $request->input('project_id'),
            'project_tracker_id' => $request->input('project_tracker_id'),
            'project_issue_statuse_id' => $request->input('project_issue_statuse_id'),
            'assigned_to_id' => $request->input('assigned_to_id'),
            'priority_id' => $request->input('priority_id'),
            'start_date' => $request->input('start_date') ?  createDatetimeFromFormat($request->start_date, "Y/m/d") : null,
            'end_date' => $request->input('end_date') ?  createDatetimeFromFormat($request->end_date, "Y/m/d") : null,
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
        ApiService::_success(trans('response.responses.200'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($project, $id)
    {
        $issue = projectIssueRepo()->delete($id);
        ApiService::_success(trans('response.responses.200'));
    }
}
