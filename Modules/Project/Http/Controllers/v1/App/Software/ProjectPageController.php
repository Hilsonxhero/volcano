<?php

namespace Modules\Project\Http\Controllers\v1\App\Software;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\Project\Transformers\v1\App\Software\ProjectResource;
use Modules\Project\Repository\v1\App\ProjectPageRepositoryInterface;
use Modules\Project\Repository\v1\App\ProjectRepository;
use Modules\Project\Transformers\v1\App\Software\ProjectPageResource;


class ProjectPageController extends Controller
{
    public $projectRepo;
    public $pageRepo;


    public function __construct(
        ProjectRepository $projectRepo,
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
        $project = $this->projectRepo->find($id, "id");
        $public_pages = $project->getMeta("public_pages");
        if (!$public_pages) {
            $user = auth()->user();
            if (!$user) {
                ApiService::_response("denied accesss", 403);
            }
            $exists = $project->members()->where('user_id', $user->id)->exists();

            if (!$exists) {
                ApiService::_response("denied accesss", 403);
            }
        }
        $page = $this->pageRepo->show($page);
        $page = new ProjectPageResource($page);
        ApiService::_success($page);
    }
}
