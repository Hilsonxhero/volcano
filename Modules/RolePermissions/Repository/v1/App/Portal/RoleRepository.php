<?php

namespace Modules\RolePermissions\Repository\v1\App\Portal;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Modules\Project\Entities\ProjectInvite;
use Modules\Project\Emails\InviteUserNotify;
use Modules\RolePermissions\Fields\RoleFields;
use Modules\RolePermissions\Entities\Role;



class RoleRepository implements RoleRepositoryInterface
{


    public function all()
    {
        $query = Role::query()->orderBy('created_at', 'desc');
        $query->when(request()->has('q'), function ($query) {
            $searchTerm = "%" . request()->q . "%";
            $query->where(function ($query) use ($searchTerm) {
                $query->where('title', 'LIKE', $searchTerm)
                    ->orWhere('name', 'LIKE', $searchTerm);
            });
        });
        return $query->paginate();
    }


    public function get()
    {
        $roles = Role::query()->get();
        return $roles;
    }

    public function show($id)
    {
        $role = $this->find($id, "id");
        return $role;
    }

    public function groups()
    {
        $roles = Role::query()->whereNull('parent_id')->with('children')->get();
        return $roles;
    }


    public function find($value, $condition = "id")
    {
        return Role::query()->where($condition, $value)->first();
    }

    public function create($data)
    {
        return Role::query()->create($data);
    }

    public function update($id, $data)
    {
        $role = $this->find($id, "id");
        return $role->update($data);
    }

    public function doesntHaveMember($recipient, $project)
    {
        return ProjectInvite::query()->where('email', $recipient)->where('project_id', $project)->exists();
    }

    public function delete($id)
    {
        $role = $this->find($id, "id");
        return $role->delete();
    }
}
