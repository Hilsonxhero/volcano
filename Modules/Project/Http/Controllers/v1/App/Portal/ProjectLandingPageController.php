<?php

namespace Modules\Project\Http\Controllers\v1\App\Portal;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Modules\Project\Entities\Project;
use Modules\Common\Enums\CommonStatus;
use Modules\Common\Services\ApiService;
use Modules\Project\Enums\ProjectPageStatus;
use Modules\Project\Transformers\v1\App\Portal\ProjectPageResource;
use Modules\Project\Http\Requests\v1\App\Portal\ProjectLandingPageRequest;
use Modules\Project\Transformers\v1\App\Portal\ProjectLandingPageResource;

class ProjectLandingPageController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, $id)
    {
        $this->authorize('manage', [Project::class, $id]);
        $pages = landingPageRepo()->get($id);
        $pages = ProjectLandingPageResource::collection($pages);
        ApiService::_success($pages);
    }

    public function children(Request $request, $id, $page)
    {
        $this->authorize('manage', [Project::class, $id]);
        $pages = landingPageRepo()->children($page);
        $pages = ProjectPageResource::collection($pages);


        ApiService::_success(
            array(
                'pages' => $pages,
                'pager' => array(
                    'pages' => $pages->lastPage(),
                    'total' => $pages->total(),
                    'current_page' => $pages->currentPage(),
                    'per_page' => $pages->perPage(),
                )
            )
        );
    }



    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(ProjectLandingPageRequest $request, $id)
    {
        $this->authorize('manage', [Project::class, $id]);
        $user = auth()->user();
        $data = array(
            'title' => $request->input('title'),
            'code' => rand(1000000, 10000000),
            'is_common_access' => $request->input('is_common_access'),
            'description' => $request->input('description'),
            'project_id' => $id,
            'user_id' => $user->id,
            'status' => CommonStatus::ACTIVE->value,
        );
        $item =  landingPageRepo()->store($data);
        $data = array(
            'title' => "عمومی",
            'name' =>  "عمومی",
            'content' =>  "عمومی",
            'project_id' => $id,
            'landing_page_id' => $item->id,
            'status' => ProjectPageStatus::ACTIVE->value,
        );
        projectPageRepo()->store($data);
        ApiService::_success(trans('response.responses.200'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $page = landingPageRepo()->show($id);
        $this->authorize('manage', [Project::class, $page->project_id]);
        $resource = new ProjectLandingPageResource($page);
        ApiService::_success($resource);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(ProjectLandingPageRequest $request, $project, $id)
    {
        $this->authorize('manage', [Project::class, $project]);

        $data = array(
            'title' => $request->input('title'),
            'code' => rand(1000000, 10000000),
            'is_common_access' => $request->input('is_common_access'),
            'description' => $request->input('description'),
            'status' => $request->input('status'),
        );
        landingPageRepo()->update($data, $id);
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
        $page = landingPageRepo()->delete($id);
        ApiService::_success(trans('response.responses.200'));
    }
}
