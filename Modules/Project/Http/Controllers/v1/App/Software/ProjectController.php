<?php

namespace Modules\Project\Http\Controllers\v1\App\Software;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\Project\Repository\v1\App\ProjectRepositoryInterface;
use Modules\Project\Transformers\v1\App\Software\ProjectResource;


class ProjectController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function show(Request $request, $id)
    {
        $project = projectRepo()->show($id);
        $project = new ProjectResource($project);
        ApiService::_success($project);
    }
}
