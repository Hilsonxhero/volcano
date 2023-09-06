<?php

namespace Modules\Project\Http\Controllers\v1\App\Portal;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\Project\Transformers\v1\App\Portal\ProjectPriorityResource;

class ProjectPriorityController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function select(Request $request)
    {
        $priorites = projectPriorityRepo()->get();
        $priorites_collection = ProjectPriorityResource::collection($priorites);
        ApiService::_success($priorites_collection);
    }
}
