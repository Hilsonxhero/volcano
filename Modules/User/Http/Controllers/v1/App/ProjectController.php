<?php

namespace Modules\User\Http\Controllers\v1\App;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\Project\Enums\ProjectStatus;
use Modules\Project\Http\Requests\v1\App\ProjectRequest;
use Modules\User\Repository\v1\Profile\UserProjectRepositoryInterface;


class ProjectController extends Controller
{
    public $projectRepo;

    public function __construct(UserProjectRepositoryInterface $projectRepo)
    {
        $this->projectRepo = $projectRepo;
    }


    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $porjects = $this->projectRepo->get();
        ApiService::_success($porjects);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function setup(ProjectRequest $request)
    {

        $user = auth()->user();

        $data = array(
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'user_id' => $user->id,
            'date_last_activity' => now(),
            'date_last_view' => now(),
            'status' => ProjectStatus::ACTIVE->value,
        );

        $porject = $this->projectRepo->store($data);

        ApiService::_success(trans('response.responses.200'));
    }
}
