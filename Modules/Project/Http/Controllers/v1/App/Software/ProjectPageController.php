<?php

namespace Modules\Project\Http\Controllers\v1\App\Software;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\Project\Transformers\v1\App\Software\ProjectPageResource;


class ProjectPageController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function show(Request $request, $id, $page)
    {
        $project = projectRepo()->find($id, "id");
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
        $page = projectPageRepo()->show($page);
        $page = new ProjectPageResource($page);
        ApiService::_success($page);
    }
}
