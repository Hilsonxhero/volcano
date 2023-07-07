<?php

namespace Modules\Project\Http\Controllers\v1\App\Portal;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\Project\Transformers\v1\App\Portal\ProjectResource;

class DashboardController extends Controller
{


    public function __construct()
    {
    }


    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $projects = userRepo()->projects();
        $projects = ProjectResource::collection($projects);
        ApiService::_success(array(
            'projects' => $projects
        ));
    }
}
