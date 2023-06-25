<?php

namespace Modules\RolePermissions\Repository\v1\App\Portal;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Modules\Project\Entities\ProjectInvite;
use Modules\Project\Emails\InviteUserNotify;
use Modules\RolePermissions\Entities\Role;
use Modules\RolePermissions\Fields\RoleFields;



class RoleRepository implements RoleRepositoryInterface
{
    public function get()
    {
        $roles = Role::query()->get();
        return $roles;
    }

    public function groups()
    {
        $roles = Role::query()->whereNull('parent_id')->with('children')->get();
        return $roles;
    }


    public function find($value, $condition = "id")
    {
        return ProjectInvite::query()->where($condition, $value)->first();
    }

    public function store($data)
    {
        foreach ($data['users'] as $key => $invited_user) {
            $membership = [
                'project_id' => $data['project']['id'],
                'email' => $invited_user['email'],
                'role' => $invited_user['role'],
                'token' => Hash::make($invited_user['email'])
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
