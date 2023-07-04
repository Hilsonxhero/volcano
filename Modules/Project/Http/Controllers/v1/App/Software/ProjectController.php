<?php

namespace Modules\Project\Http\Controllers\v1\App\Software;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\Project\Transformers\v1\App\Software\ProjectResource;
use Modules\User\Repository\v1\Profile\UserProjectRepositoryInterface;


class ProjectController extends Controller
{
    public $projectRepo;

    public function __construct(UserProjectRepositoryInterface $projectRepo)
    {
        $this->projectRepo = $projectRepo;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function show(Request $request, $id)
    {
        $project = $this->projectRepo->show($id);
        $project = new ProjectResource($project);
        ApiService::_success($project);
    }
}
