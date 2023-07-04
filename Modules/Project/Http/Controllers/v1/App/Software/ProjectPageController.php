<?php

namespace Modules\Project\Http\Controllers\v1\App\Software;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\Project\Transformers\v1\App\Software\ProjectResource;
use Modules\Project\Repository\v1\App\ProjectPageRepositoryInterface;
use Modules\Project\Transformers\v1\App\Software\ProjectPageResource;
use Modules\User\Repository\v1\Profile\UserProjectRepositoryInterface;


class ProjectPageController extends Controller
{
    public $projectRepo;
    public $pageRepo;


    public function __construct(
        UserProjectRepositoryInterface $projectRepo,
        ProjectPageRepositoryInterface $pageRepo
    ) {
        $this->projectRepo = $projectRepo;
        $this->pageRepo = $pageRepo;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function show(Request $request, $id, $page)
    {
        $page = $this->pageRepo->show($page);
        $page = new ProjectPageResource($page);
        ApiService::_success($page);
    }
}
