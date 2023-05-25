<?php

namespace Modules\Project\Http\Controllers\v1\App;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\Project\Repository\v1\App\ProjectInviteRepositoryInterface;
use Modules\Project\Repository\v1\App\ProjectMembershipRepositoryInterface;
use Modules\Project\Repository\v1\App\ProjectRepositoryInterface;
use Modules\User\Repository\v1\App\UserRepositoryInterface;

class ProjectInviteController extends Controller
{
    public $projectInviteRepo;
    public $projectMembershipRepo;
    public $projectRepo;
    public $userRepo;

    public function __construct(
        UserRepositoryInterface $userRepo,
        ProjectRepositoryInterface $projectRepo,
        ProjectInviteRepositoryInterface $projectInviteRepo,
        ProjectMembershipRepositoryInterface $projectMembershipRepo
    ) {
        $this->projectInviteRepo = $projectInviteRepo;
        $this->projectMembershipRepo = $projectMembershipRepo;
        $this->projectRepo = $projectRepo;
        $this->userRepo = $userRepo;
    }

    public function store(Request $request)
    {
        $project = $this->projectRepo->find($request->project);

        $inviter = $this->userRepo->find($request->inviter, "email");

        $data = array(
            'project' => $project,
            'users' => $request->users,
            'inviter' => $inviter->username
        );

        $this->projectInviteRepo->store($data);

        ApiService::_success(trans('response.responses.200'));
    }

    public function confirmation(Request $request)
    {
        $data = array(
            'project' => $request->project,
            'email' => $request->email
        );

        $confirmation =  $this->projectMembershipRepo->store($data);

        if (!$confirmation) {
            ApiService::_success(trans('response.invitation.invalid'));
        }

        ApiService::_success(trans('response.responses.200'));
    }
}
