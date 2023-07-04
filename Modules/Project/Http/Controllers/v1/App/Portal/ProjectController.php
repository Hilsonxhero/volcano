<?php

namespace Modules\Project\Http\Controllers\v1\App\Portal;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\Project\Enums\ProjectMemberStatus;
use Modules\Project\Enums\ProjectStatus;
use Modules\Project\Http\Requests\v1\App\ProjectRequest;
use Modules\Project\Transformers\v1\App\Portal\ProjectResource;
use Modules\Project\Transformers\v1\App\Portal\ShowProjectResource;
use Modules\User\Repository\v1\Profile\UserProjectRepositoryInterface;
use Modules\Project\Repository\v1\App\ProjectMembershipRepositoryInterface;


class ProjectController extends Controller
{
    public $projectRepo;
    public $projectMembershipRepo;

    public function __construct(
        UserProjectRepositoryInterface $projectRepo,
        ProjectMembershipRepositoryInterface $projectMembershipRepo

    ) {
        $this->projectRepo = $projectRepo;
        $this->projectMembershipRepo = $projectMembershipRepo;
    }


    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        // $user = auth()->user();
        // return $user->memberships()->with('project')->paginate();
        $projects = $this->projectRepo->paginate();

        $projects = ProjectResource::collection($projects);
        ApiService::_success(array(
            'projects' => $projects->items(),
            'pager' => array(
                'pages' => $projects->lastPage(),
                'total' => $projects->total(),
                'current_page' => $projects->currentPage(),
                'per_page' => $projects->perPage(),

            )
        ));
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function show(Request $request, $id)
    {
        $project = $this->projectRepo->show($id);
        $project = new ShowProjectResource($project);
        ApiService::_success($project);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function setup(ProjectRequest $request)
    {
        $user = auth()->user();
        $data = array(
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'user_id' => $user->id,
            'date_last_activity' => now(),
            'date_last_view' => now(),
            'status' => ProjectStatus::ACTIVE->value,
        );
        $project = $this->projectRepo->store($data);
        $this->projectMembershipRepo->create(array(
            'project_id' => $project->id,
            'user_id' => $user->id,
            'status' => ProjectMemberStatus::ACTIVE->value
        ));
        $user->assignRole("system_administrator");
        $project->setMeta([
            'public_pages' =>  true
        ]);
        $project->save();
        ApiService::_success(trans('response.responses.200'));
    }
}
