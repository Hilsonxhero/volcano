<?php

namespace Modules\Project\Http\Controllers\v1\App\Portal;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\Project\Enums\ProjectTimeCategoryStatus;
use Modules\Project\Http\Requests\v1\App\ProjectTimeCategoryRequest;
use Modules\Project\Transformers\v1\App\Portal\ProjectTimeCategoryResource;

class ProjectTimeCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, $id)
    {
        $categories = projectTimeCategoryRepo()->all($id);
        $categories_collection = ProjectTimeCategoryResource::collection($categories);
        ApiService::_success(
            array(
                'categories' => $categories_collection,
                'pager' => array(
                    'pages' => $categories_collection->lastPage(),
                    'total' => $categories_collection->total(),
                    'current_page' => $categories_collection->currentPage(),
                    'per_page' => $categories_collection->perPage(),
                )
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(ProjectTimeCategoryRequest $request)
    {
        $data = array(
            'title' => $request->input('title'),
            'is_default' => $request->input('is_default'),
            'project_id' => $request->input('project_id'),
            'status' => ProjectTimeCategoryStatus::ACTIVE->value,
        );
        $category = projectTimeCategoryRepo()->store($data);
        ApiService::_success(trans('response.responses.200'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($prokect, $id)
    {
        $category = projectTimeCategoryRepo()->show($id);
        $resource = new ProjectTimeCategoryResource($category);
        ApiService::_success($resource);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(ProjectTimeCategoryRequest $request, $project, $id)
    {
        $data = array(
            'title' => $request->input('title'),
            'is_default' => $request->input('is_default'),
            'project_id' => $request->input('project_id'),
            'status' => $request->status,
        );
        $category = projectTimeCategoryRepo()->update($data, $id);
        ApiService::_success(trans('response.responses.200'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($project, $id)
    {
        $category = projectTimeCategoryRepo()->delete($id);
        ApiService::_success(trans('response.responses.200'));
    }
}
