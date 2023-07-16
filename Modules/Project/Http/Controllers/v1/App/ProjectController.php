<?php

namespace Modules\Project\Http\Controllers\v1\App;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Project\Transformers\v1\App\ProjectResource;

class ProjectController extends Controller
{
    public function show(Request $request, $id)
    {
        try {
            $project = projectRepo()->show($id);
            $project = new ProjectResource($project);
            ApiService::_success($project);
        } catch (ModelNotFoundException $e) {
            return  ApiService::_response(trans('response.responses.404'), 404);
        }
    }
}
