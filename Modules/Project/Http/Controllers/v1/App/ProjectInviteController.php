<?php

namespace Modules\Project\Http\Controllers\v1\App;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\Project\Transformers\v1\App\Portal\ProjectInviteResource;


class ProjectInviteController extends Controller
{

    public function store(Request $request)
    {
        $user = auth()->user();
        $project = projectRepo()->find($request->project);
        $data = array(
            'project' => $project,
            'users' => $request->users,
            'inviter' => $user
        );
        projectInviteRepo()->store($data);
        ApiService::_success(trans('response.responses.200'));
    }
    public function show(Request $request, $id)
    {
        $invite = projectInviteRepo()->show($id);
        $invite = new ProjectInviteResource($invite);
        return $invite;
    }
    public function confirmation(Request $request)
    {
        $invite = projectInviteRepo()->findByToken($request->token);
        $data = array(
            'project' => $invite->project_id,
            'email' => $invite->email
        );
        $confirmation =  projectMembershipRepo()->store($data);
        if (!$confirmation) {
            ApiService::_success(trans('response.invitation.invalid'));
        }
        ApiService::_success(trans('response.responses.200'));
    }
    public function decline(Request $request)
    {
        $invite = projectInviteRepo()->findByToken($request->token);
        projectInviteRepo()->delete($invite->id);
        ApiService::_success(trans('response.responses.200'));
    }
}
