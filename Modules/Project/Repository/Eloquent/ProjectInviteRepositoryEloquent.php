<?php

namespace Modules\Project\Repository\Eloquent;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Modules\Project\Entities\ProjectInvite;
use Modules\Project\Emails\InviteUserNotify;
use Modules\Project\Repository\Contracts\ProjectInviteRepository;

class ProjectInviteRepositoryEloquent implements ProjectInviteRepository
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
            // $this->doesntHaveMember($membership['email'],  $membership['project_id']) &&
            if (
                !projectMembershipRepo()->doesntHaveMember($membership['email'],  $membership['project_id'])
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
        return ProjectInvite::query()
            ->where('email', $recipient)
            ->where('confirmed', false)
            ->where('project_id', $project)->exists();
    }
}
