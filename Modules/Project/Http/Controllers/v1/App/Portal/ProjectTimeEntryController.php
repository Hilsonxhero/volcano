<?php

namespace Modules\Project\Http\Controllers\v1\App\Portal;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Modules\Project\Entities\Project;
use Modules\Common\Services\ApiService;

use Modules\Project\Http\Requests\v1\App\ProjectIssueTimeRequest;;

use Modules\Project\Transformers\v1\App\Portal\ProjectTimeEntryResource;

class ProjectTimeEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, $id)
    {
        $this->authorize('manage', [Project::class, $id]);

        $time_entries = ProjectTimeEntryRepo()->all($id);
        $time_entries_collection = ProjectTimeEntryResource::collection($time_entries);
        ApiService::_success(
            array(
                'times' => $time_entries_collection,
                'pager' => array(
                    'pages' => $time_entries_collection->lastPage(),
                    'total' => $time_entries_collection->total(),
                    'current_page' => $time_entries_collection->currentPage(),
                    'per_page' => $time_entries_collection->perPage(),
                )
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(ProjectIssueTimeRequest $request, $project, $id)
    {
        $this->authorize('manage', [Project::class, $project]);

        $user = auth()->user();
        $time = ProjectTimeEntryRepo()->find($request->project_issue_id);
        $data = array(
            'project_id' => $time->project_id,
            'project_issue_id' => $time->id,
            'project_time_category_id' => $request->project_time_category_id,
            'user_id' => $user->id,
            'spent_on' => $request->input('spent_on') ? createDatetimeFromFormat($request->spent_on) : null,
            'hours' => $request->hours,
            'description' => $request->input('description'),
        );
        $time = ProjectTimeEntryRepo()->store($data);
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

        $time = ProjectTimeEntryRepo()->show($id);
        $resource = new ProjectTimeEntryResource($time);
        ApiService::_success($resource);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(ProjectIssueTimeRequest $request, $project, $id)
    {
        $this->authorize('manage', [Project::class, $project]);

        $user = auth()->user();
        $data = array(
            'project_id' => $time->project_id,
            'project_issue_id' => $time->id,
            'project_time_category_id' => $request->project_time_category_id,
            'user_id' => $user->id,
            'spent_on' => $request->input('spent_on') ? createDatetimeFromFormat($request->spent_on) : null,
            'hours' => $request->hours,
            'description' => $request->input('description'),
        );
        $time = ProjectTimeEntryRepo()->update($data, $id);
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

        $time = ProjectTimeEntryRepo()->delete($id);
        ApiService::_success(trans('response.responses.200'));
    }
}
