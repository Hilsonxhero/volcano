<?php

namespace Modules\Project\Http\Controllers\v1\Management;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\Category\Enum\CategoryStatus;
use Modules\Project\Transformers\v1\Management\ProjectResource;
use Modules\Project\Transformers\v1\Management\ProjectMemberResource;

class ProjectMemberController extends Controller
{
    public function index($project)
    {
        $members = projectMembershipRepo()->all($project);
        $members_collection = ProjectMemberResource::collection($members);
        ApiService::_success(
            array(
                'members' => $members_collection,
                'pager' => array(
                    'pages' => $members_collection->lastPage(),
                    'total' => $members_collection->total(),
                    'current_page' => $members_collection->currentPage(),
                    'per_page' => $members_collection->perPage(),
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
            'parent' => ['nullable', 'exists:members,id'],
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
            'parent_id' => $request->parent,
            'status' => CategoryStatus::ENABLE->value
        ];
        $category = projectMembershipRepo()->create($data);

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
        $category = projectMembershipRepo()->show($id);
        return new ProjectMemberResource($category);
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
            'parent' => ['nullable', 'exists:members,id'],
        ]);
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
            'parent_id' => $request->parent,
        ];
        $category = projectMembershipRepo()->update($id, $data);

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
        projectMembershipRepo()->delete($id);
        ApiService::_success(trans('response.responses.200'));
    }
}
