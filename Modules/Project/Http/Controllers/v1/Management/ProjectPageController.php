<?php

namespace Modules\Project\Http\Controllers\v1\Management;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Category\Enum\CategoryStatus;
use Modules\Common\Services\ApiService;
use Modules\Project\Transformers\v1\Management\ProjectPageResource;
use Modules\Project\Transformers\v1\Management\ProjectResource;

class ProjectPageController extends Controller
{
    public function index($project)
    {
        $pages = projectPageRepo()->all($project);
        $pages_collection = ProjectPageResource::collection($pages);
        ApiService::_success(
            array(
                'pages' => $pages_collection,
                'pager' => array(
                    'pages' => $pages_collection->lastPage(),
                    'total' => $pages_collection->total(),
                    'current_page' => $pages_collection->currentPage(),
                    'per_page' => $pages_collection->perPage(),
                )
            )
        );
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
            'parent' => ['nullable', 'exists:pages,id'],
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
            'parent_id' => $request->parent,
            'status' => CategoryStatus::ENABLE->value
        ];
        $category = projectPageRepo()->create($data);

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
        $category = projectPageRepo()->show($id);
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
            'parent' => ['nullable', 'exists:pages,id'],
        ]);
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
            'parent_id' => $request->parent,
        ];
        $category = projectPageRepo()->update($id, $data);

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
    public function destroy($project, $id)
    {
        projectPageRepo()->delete($id);
        ApiService::_success(trans('response.responses.200'));
    }
}
