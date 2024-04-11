<?php

namespace Modules\Project\Http\Controllers\v1\App\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Common\Enums\CommonStatus;
use Modules\Common\Services\ApiService;
use Modules\Project\Entities\Project;
use Modules\Project\Http\Requests\v1\App\ProjectIssueStatusRequest;
use Modules\Project\Transformers\v1\App\Portal\ProjectIssueStatusResource;

class ProjectIssueStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, $id)
    {
        $this->authorize('manage', [Project::class, $id]);

        $statuses = projectIssueStatusRepo()->all($id);
        $statuses_collection = ProjectIssueStatusResource::collection($statuses);
        ApiService::_success(
            array(
                'statuses' => $statuses_collection,
                'pager' => array(
                    'pages' => $statuses_collection->lastPage(),
                    'total' => $statuses_collection->total(),
                    'current_page' => $statuses_collection->currentPage(),
                    'per_page' => $statuses_collection->perPage(),
                )
            )
        );
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function select(Request $request, $id)
    {
        $this->authorize('manage', [Project::class, $id]);

        $statuses = projectIssueStatusRepo()->get($id);
        $statuses_collection = ProjectIssueStatusResource::collection($statuses);
        ApiService::_success($statuses_collection);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(ProjectIssueStatusRequest $request)
    {
        $this->authorize('manage', [Project::class, $request->input('project_id')]);

        $data = array(
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'is_closed' => $request->input('is_closed'),
            'project_id' => $request->input('project_id'),
            'status' => CommonStatus::ACTIVE->value,
        );
        $status = projectIssueStatusRepo()->store($data);
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

        $status = projectIssueStatusRepo()->show($id);
        $resource = new ProjectIssueStatusResource($status);
        ApiService::_success($resource);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(ProjectIssueStatusRequest $request, $project, $id)
    {
        $this->authorize('manage', [Project::class, $project]);

        $data = array(
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'is_closed' => $request->input('is_closed'),
            'project_id' => $request->input('project_id'),
            'status' => $request->status,
        );
        $status = projectIssueStatusRepo()->update($data, $id);
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

        $status = projectIssueStatusRepo()->delete($id);
        ApiService::_success(trans('response.responses.200'));
    }
}
