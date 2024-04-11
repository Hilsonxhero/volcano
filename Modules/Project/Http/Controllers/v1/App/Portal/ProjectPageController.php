<?php

namespace Modules\Project\Http\Controllers\v1\App\Portal;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Modules\Common\Services\ApiService;
use Modules\Project\Entities\Project;
use Modules\Project\Enums\ProjectPageStatus;
use Modules\Project\Http\Requests\v1\App\ProjectPageRequest;
use Modules\Project\Transformers\v1\App\Portal\ProjectPageResource;

class ProjectPageController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, $id)
    {
        $this->authorize('manage', [Project::class, $id]);
        $pages = projectPageRepo()->get($id);
        $pages = ProjectPageResource::collection($pages);
        ApiService::_success($pages);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(ProjectPageRequest $request)
    {
        $this->authorize('manage', [Project::class, $request->input('project_id')]);

        $data = array(
            'title' => $request->input('title'),
            'name' => $request->input('name'),
            'content' => $request->input('content'),
            'project_id' => $request->input('project_id'),
            'parent_id' => $request->input('parent_id'),
            'status' => ProjectPageStatus::ACTIVE->value,
        );
        $page = projectPageRepo()->store($data);
        ApiService::_success(trans('response.responses.200'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $page = projectPageRepo()->show($id);
        $this->authorize('manage', [Project::class, $page->project_id]);
        $resource = new ProjectPageResource($page);
        ApiService::_success($resource);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(ProjectPageRequest $request, $project, $id)
    {
        $this->authorize('manage', [Project::class, $project]);

        $data = array(
            'title' => $request->input('title'),
            'name' => $request->input('name'),
            'content' => $request->input('content'),
            'project_id' => $request->input('project_id'),
            'parent_id' => $request->input('parent_id'),
            // 'status' => $request->input('status')
        );
        $page = projectPageRepo()->update($data, $id);
        ApiService::_success(trans('response.responses.200'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($project, $id)
    {
        $this->authorize('manage', [Project::class, $project]);
        $page = projectPageRepo()->delete($id);
        ApiService::_success(trans('response.responses.200'));
    }
}
