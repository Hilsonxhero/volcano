<?php

namespace Modules\Project\Http\Controllers\v1\App\Portal;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\Project\Entities\Project;
use Modules\Project\Enums\ProjectPageStatus;
use Modules\Project\Http\Requests\v1\App\ProjectPageRequest;
use Modules\Project\Repository\v1\App\ProjectMembershipRepositoryInterface;
use Modules\Project\Repository\v1\App\ProjectPageRepositoryInterface;
use Modules\Project\Repository\v1\App\ProjectRepositoryInterface;
use Modules\Project\Transformers\v1\App\Portal\ProjectMemberResource;
use Modules\Project\Transformers\v1\App\Portal\ProjectPageResource;

class ProjectUserController extends Controller
{
    public $projectMemberRepo;
    public $projectRepo;


    public function __construct(
        ProjectRepositoryInterface $projectRepo,
        ProjectMembershipRepositoryInterface $projectMemberRepo
    ) {
        $this->projectMemberRepo = $projectMemberRepo;
        $this->projectRepo = $projectRepo;
    }


    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, $id)
    {
        $members = $this->projectRepo->members($id);
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
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(ProjectPageRequest $request)
    {
        $data = array(
            'title' => $request->input('title'),
            'name' => $request->input('name'),
            'content' => $request->input('content'),
            'project_id' => $request->input('project_id'),
            'parent_id' => $request->input('parent_id'),
            'status' => ProjectPageStatus::ACTIVE->value,
        );
        $page = $this->projectMemberRepo->store($data);
        ApiService::_success(trans('response.responses.200'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $page = $this->projectMemberRepo->show($id);
        $resource = new ProjectPageResource($page);
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
        $data = array(
            'title' => $request->input('title'),
            'name' => $request->input('name'),
            'content' => $request->input('content'),
            'project_id' => $request->input('project_id'),
            'parent_id' => $request->input('parent_id'),
            // 'status' => $request->input('status')
        );
        $page = $this->projectMemberRepo->update($data, $id);
        ApiService::_success(trans('response.responses.200'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($project, $id)
    {
        $page = $this->projectMemberRepo->delete($id);
        ApiService::_success(trans('response.responses.200'));
    }
}
