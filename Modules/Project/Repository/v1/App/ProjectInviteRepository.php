<?php

namespace Modules\Project\Repository\v1\App;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Modules\Project\Entities\ProjectInvite;
use Modules\Project\Emails\InviteUserNotify;



class ProjectInviteRepository implements ProjectInviteRepositoryInterface
{

    public function find($value, $condition = "id")
    {
        return ProjectInvite::query()->where($condition, $value)->first();
    }

    public function findByToken($token)
    {
        $invite = $this->find($token, "token");
        return $invite;
    }
    public function show($id)
    {
        $invite = $this->find($id, "id");
        return $invite;
    }

    public function delete($id)
    {
        $invite = $this->find($id, "id");
        return $invite->delete();
    }


    public function store($data)
    {
        foreach ($data['users'] as $key => $invited_user) {
            $membership = [
                'project_id' => $data['project']['id'],
                'user_id' => $data['inviter']['id'],
                'email' => $invited_user['email'],
                'role' => $invited_user['role'],
                'token' => Hash::make($invited_user['email'])
            ];

            if (
                !$this->doesntHaveMember($membership['email'],  $membership['project_id']) &&
                !resolve(ProjectMembershipRepositoryInterface::class)->doesntHaveMember($membership['email'],  $membership['project_id'])
            ) {
                $project_invite =   ProjectInvite::query()->create($membership);

                $mail_data  = [
                    'name' => $data['inviter']['username'],
                    'project' => $data['project'],
                    'url' => front_path(getenv("FRONT_INVITE_CALLBACK"), ['token' => $membership['token'], 'id' => $project_invite->id])
                ];

                Mail::to($membership['email'])->send(new InviteUserNotify($mail_data));
            }
        }

        return true;
    }

    public function doesntHaveMember($recipient, $project)
    {
        return ProjectInvite::query()->where('email', $recipient)->where('project_id', $project)->exists();
    }
}
