<?php

namespace Modules\Project\Http\Controllers\v1\App\Portal;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\Project\Enums\ProjectStatus;
use Modules\Project\Http\Requests\v1\App\ProjectRequest;
use Modules\Project\Transformers\v1\App\Portal\ProjectResource;
use Modules\Project\Transformers\v1\App\Portal\ShowProjectResource;
use Modules\User\Repository\v1\Profile\UserProjectRepositoryInterface;


class DashboardController extends Controller
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
    public function index()
    {
        $projects = $this->projectRepo->get();
        $projects = ProjectResource::collection($projects);
        ApiService::_success(array(
            'projects' => $projects
        ));
    }
}
