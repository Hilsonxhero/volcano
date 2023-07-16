<?php

namespace Modules\Project\Http\Controllers\v1\Management;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Category\Enum\CategoryStatus;
use Modules\Common\Services\ApiService;
use Modules\Project\Transformers\v1\Management\ProjectResource;

class ProjectController extends Controller
{

    public function index()
    {
        $projects = projectRepo()->all();
        $projects_collection = ProjectResource::collection($projects);
        ApiService::_success(
            array(
                'projects' => $projects_collection,
                'pager' => array(
                    'pages' => $projects_collection->lastPage(),
                    'total' => $projects_collection->total(),
                    'current_page' => $projects_collection->currentPage(),
                    'per_page' => $projects_collection->perPage(),
                )
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */

    public function select(Request $request)
    {
        $projects = projectRepo()->select($request->q);
        ApiService::_success($projects);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        ApiService::Validator($request->all(), [
            'title' => ['required'],
            'description' => ['required'],
            'link' => ['nullable'],
            'parent' => ['nullable', 'exists:projects,id'],
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
            'parent_id' => $request->parent,
            'status' => CategoryStatus::ENABLE->value
        ];
        $category = projectRepo()->create($data);

        if ($request->filled('image')) {
            base64($request->image) ? $category->addMediaFromBase64($request->image)->toMediaCollection()
                : $category->addMedia($request->image)->toMediaCollection();
        }

        ApiService::_success($category);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $category = projectRepo()->show($id);
        return new ProjectResource($category);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        ApiService::Validator($request->all(), [
            'title' => ['required'],
            'description' => ['required'],
            'link' => ['nullable'],
            'parent' => ['nullable', 'exists:projects,id'],
        ]);
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
            'parent_id' => $request->parent,
        ];
        $category = projectRepo()->update($id, $data);

        if ($request->image) {
            $category->clearMediaCollectionExcept();
            base64($request->image) ? $category->addMediaFromBase64($request->image)->toMediaCollection()
                : $category->addMedia($request->image)->toMediaCollection();
        }


        ApiService::_success(trans('response.responses.200'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        projectRepo()->delete($id);
        ApiService::_success(trans('response.responses.200'));
    }
}
