<?php

namespace Modules\Project\Http\Controllers\v1\App\Portal;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Modules\Project\Entities\Project;
use Modules\Common\Services\ApiService;
use Modules\Project\Enums\ProjectPageStatus;
use Modules\Project\Http\Requests\v1\App\ProjectPageRequest;
use Modules\Project\Transformers\v1\App\Portal\ProjectPageResource;
use Modules\Project\Transformers\v1\App\Portal\ProjectMemberResource;

class ProjectUserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, $id)
    {
        // $this->authorize('manage', [Project::class, $id]);

        $members = projectRepo()->members($id);
        $members = ProjectMemberResource::collection($members);
        ApiService::_success(array(
            'members' => $members->items(),
            'pager' => array(
                'pages' => $members->lastPage(),
                'total' => $members->total(),
                'current_page' => $members->currentPage(),
                'per_page' => $members->perPage(),
            )
        ));
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function select(Request $request, $id)
    {
        $this->authorize('manage', [Project::class, $id]);

        $members = projectMembershipRepo()->getByProject($id);
        $members = ProjectMemberResource::collection($members);
        ApiService::_success($members);
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(ProjectPageRequest $request)
    {
        $this->authorize('manage', [Project::class, $request->input('project_id')]);

        $data = array(
            'title' => $request->input('title'),
            'name' => $request->input('name'),
            'content' => $request->input('content'),
            'project_id' => $request->input('project_id'),
            'parent_id' => $request->input('parent_id'),
            'status' => ProjectPageStatus::ACTIVE->value,
        );
        $page = projectMembershipRepo()->store($data);
        ApiService::_success(trans('response.responses.200'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $member = projectMembershipRepo()->show($id);
        $this->authorize('manage', [Project::class, $member->project_id]);
        $resource = new ProjectPageResource($member);
        ApiService::_success($resource);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(ProjectPageRequest $request, $project, $id)
    {
        $this->authorize('manage', [Project::class, $project]);

        $data = array(
            'title' => $request->input('title'),
            'name' => $request->input('name'),
            'content' => $request->input('content'),
            'project_id' => $request->input('project_id'),
            'parent_id' => $request->input('parent_id'),
            // 'status' => $request->input('status')
        );
        $page = projectMembershipRepo()->update($data, $id);
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
        $user = projectMembershipRepo()->delete($id);
        ApiService::_success(trans('response.responses.200'));
    }
}
