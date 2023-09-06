<?php

namespace Modules\Project\Http\Controllers\v1\App\Portal;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Common\Enums\CommonStatus;
use Modules\Common\Services\ApiService;
use Modules\Project\Http\Requests\v1\App\ProjectTrackerRequest;
use Modules\Project\Transformers\v1\App\Portal\ProjectTrackerResource;

class ProjectTrackerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, $id)
    {
        $trackers = projectTrackerRepo()->all($id);
        $trackers_collection = ProjectTrackerResource::collection($trackers);
        ApiService::_success(
            array(
                'trackers' => $trackers_collection,
                'pager' => array(
                    'pages' => $trackers_collection->lastPage(),
                    'total' => $trackers_collection->total(),
                    'current_page' => $trackers_collection->currentPage(),
                    'per_page' => $trackers_collection->perPage(),
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
        $trackers = projectTrackerRepo()->get($id);
        $trackers_collection = ProjectTrackerResource::collection($trackers);
        ApiService::_success($trackers_collection);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(ProjectTrackerRequest $request)
    {
        $data = array(
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'project_id' => $request->input('project_id'),
            'status' => CommonStatus::ACTIVE->value,
        );
        $category = projectTrackerRepo()->store($data);
        ApiService::_success(trans('response.responses.200'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($prokect, $id)
    {
        $category = projectTrackerRepo()->show($id);
        $resource = new ProjectTrackerResource($category);
        ApiService::_success($resource);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(ProjectTrackerRequest $request, $project, $id)
    {
        $data = array(
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'project_id' => $request->input('project_id'),
            'status' => $request->status,
        );
        $category = projectTrackerRepo()->update($data, $id);
        ApiService::_success(trans('response.responses.200'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($project, $id)
    {
        $category = projectTrackerRepo()->delete($id);
        ApiService::_success(trans('response.responses.200'));
    }
}
