<?php

namespace Modules\Project\Http\Controllers\v1\App;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Project\Transformers\v1\App\ProjectResource;
use Modules\User\Repository\v1\App\UserRepositoryInterface;
use Modules\Project\Repository\v1\App\ProjectRepositoryInterface;


class ProjectController extends Controller
{
    public $projectRepo;
    public $userRepo;

    public function __construct(
        UserRepositoryInterface $userRepo,
        ProjectRepositoryInterface $projectRepo,

    ) {
        $this->projectRepo = $projectRepo;
        $this->userRepo = $userRepo;
    }


    public function show(Request $request, $id)
    {
        try {
            $project = $this->projectRepo->show($id);
            $project = new ProjectResource($project);
            ApiService::_success($project);
        } catch (ModelNotFoundException $e) {
            return  ApiService::_response(trans('response.responses.404'), 404);
        }
    }
}
