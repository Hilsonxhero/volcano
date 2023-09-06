<?php

namespace Modules\Project\Repository\Eloquent;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Modules\Project\Entities\ProjectInvite;
use Modules\Project\Entities\ProjectMembership;
use Modules\Project\Enums\ProjectMemberStatus;
use Modules\Project\Repository\Contracts\ProjectMembershipRepository;

class ProjectMembershipRepositoryEloquent implements ProjectMembershipRepository
{

    public function all($project)
    {
        $query = ProjectMembership::orderBy('created_at', 'desc')->where('project_id', $project);
        return $query->paginate();
    }
    public function find($value, $condition = "id")
    {
        return ProjectMembership::query()->where($condition, $value)->first();
    }

    public function getByProject($project)
    {
        $query = ProjectMembership::orderBy('created_at', 'desc')->where('project_id', $project);
        return $query->get();
    }


    public function store($data)
    {
        $user = auth()->user();

        $exists = ProjectInvite::query()->where('email', $user->email)->where('project_id', $data['project'])->first();

        if (!$exists) {
            return false;
        }

        if (Carbon::parse($exists->created_at)->addSeconds(now()->addDays(2)->diffInSeconds())->isPast() || !Hash::check($user->email, $exists->token)) {
            return false;
        }

        $membership_exists = ProjectMembership::query()->where('user_id', $user->id)->where('project_id', $data['project'])->first();

        if (!$membership_exists) {
            $user->memberships()->create([
                'project_id' => $data['project'],
                'status' => ProjectMemberStatus::ACTIVE->value,
            ]);
            $user->assignRole($exists->role);
            $exists->delete();
        }

        return true;
    }
    public function create($data)
    {
        return   ProjectMembership::query()->create($data);
    }
    public function doesntHaveMember($recipient, $project)
    {
        return  ProjectMembership::query()->where('project_id', $project)->whereHas('user', function ($query) use ($recipient) {
            return $query->where('email', $recipient);
        })->exists();
    }
    public function delete($id)
    {
        $user = $this->find($id, "id");
        return $user->delete();
    }
}
