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

    public function store($data)
    {
        foreach ($data['users'] as $key => $email) {
            $membership = [
                'project_id' => $data['project']['id'],
                'email' => $email,
                'token' => Hash::make($email)
            ];

            if (
                !$this->doesntHaveMember($membership['email'],  $membership['project_id']) &&
                !resolve(ProjectMembershipRepositoryInterface::class)->doesntHaveMember($membership['email'],  $membership['project_id'])
            ) {
                ProjectInvite::query()->create($membership);

                $mail_data  = [
                    'name' => $data['inviter'],
                    'project' => $data['project'],
                    'url' => front_path(getenv("FRONT_INVITE_CALLBACK"), ['token' => $membership['token']])
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
