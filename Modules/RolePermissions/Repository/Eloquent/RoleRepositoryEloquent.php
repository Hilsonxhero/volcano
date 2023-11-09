<?php

namespace Modules\RolePermissions\Repository\Eloquent;

use Modules\RolePermissions\Entities\Role;
use Modules\RolePermissions\Repository\Contracts\RoleRepository;

class RoleRepositoryEloquent implements RoleRepository
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

    public function select($project)
    {
        $query = Role::orderBy('created_at', 'desc')->where('project_id', $project);
        $query->when(request()->has('q'), function ($query) {
            $searchTerm = "%" . request()->q . "%";
            $query->where(function ($query) use ($searchTerm) {
                $query->where('title', 'LIKE', $searchTerm)
                    ->orWhere('name', 'LIKE', $searchTerm);
            });
        });
        return $query->paginate(30);
    }


    public function get($project = null)
    {
        if (!is_null($project)) {
            $query = Role::query()->orderBy('created_at', 'desc')->where('project_id', $project);
            $query->when(request()->has('q'), function ($query) {
                $searchTerm = "%" . request()->q . "%";
                $query->where(function ($query) use ($searchTerm) {
                    $query->where('title', 'LIKE', $searchTerm)
                        ->orWhere('name', 'LIKE', $searchTerm);
                });
            });
            return $query->paginate();
        }
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
        $role->update($data);
        return $role;
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
