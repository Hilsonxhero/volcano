<?php

namespace Modules\Project\Http\Controllers\v1\App;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\Project\Repository\v1\App\ProjectInviteRepositoryInterface;
use Modules\Project\Repository\v1\App\ProjectMembershipRepositoryInterface;
use Modules\Project\Repository\v1\App\ProjectRepositoryInterface;
use Modules\Project\Transformers\v1\App\Portal\ProjectInviteResource;
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
        $user = auth()->user();
        $project = $this->projectRepo->find($request->project);
        // $inviter = $this->userRepo->find($request->inviter, "email");
        $data = array(
            'project' => $project,
            'users' => $request->users,
            'inviter' => $user
        );
        // return $data['inviter']['username'];
        $this->projectInviteRepo->store($data);
        ApiService::_success(trans('response.responses.200'));
    }

    public function show(Request $request, $id)
    {
        $invite = $this->projectInviteRepo->show($id);
        $invite = new ProjectInviteResource($invite);
        return $invite;
    }

    public function confirmation(Request $request)
    {
        $invite = $this->projectInviteRepo->findByToken($request->token);
        $data = array(
            'project' => $invite->project_id,
            'email' => $invite->email
        );
        $confirmation =  $this->projectMembershipRepo->store($data);
        if (!$confirmation) {
            ApiService::_success(trans('response.invitation.invalid'));
        }
        ApiService::_success(trans('response.responses.200'));
    }
    public function decline(Request $request)
    {
        $invite = $this->projectInviteRepo->findByToken($request->token);
        $this->projectInviteRepo->delete($invite->id);
        ApiService::_success(trans('response.responses.200'));
    }
}
