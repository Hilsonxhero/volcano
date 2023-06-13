<?php

namespace Modules\Project\Http\Controllers\v1\App\Portal;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\Project\Enums\ProjectPageStatus;
use Modules\Project\Http\Requests\v1\App\ProjectPageRequest;
use Modules\Project\Repository\v1\App\ProjectPageRepositoryInterface;
use Modules\Project\Transformers\v1\App\Portal\ProjectPageResource;

class ProjectPageController extends Controller
{
    public $pageRepo;

    public function __construct(ProjectPageRepositoryInterface $pageRepo)
    {
        $this->pageRepo = $pageRepo;
    }


    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, $id)
    {
        $pages = $this->pageRepo->get($id);
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
        $data = array(
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'project_id' => $request->input('project_id'),
            'parent_id' => $request->input('parent_id'),
            'status' => ProjectPageStatus::ACTIVE->value,
        );
        $page = $this->pageRepo->store($data);
        ApiService::_success(trans('response.responses.200'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $page = $this->pageRepo->show($id);
        $resource = new ProjectPageResource($page);
        ApiService::_success($resource);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(ProjectPageRequest $request, $id)
    {
        $data = array(
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'project_id' => $request->input('project_id'),
            'parent_id' => $request->input('parent_id'),
            'status' => $request->input('status')
        );
        $page = $this->pageRepo->update($data, $id);
        ApiService::_success(trans('response.responses.200'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
