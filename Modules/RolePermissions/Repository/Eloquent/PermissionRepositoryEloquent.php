<?php

namespace Modules\RolePermissions\Repository\Eloquent;

use Modules\RolePermissions\Entities\Permission;
use Modules\RolePermissions\Repository\Contracts\PermissionRepository;

class PermissionRepositoryEloquent implements PermissionRepository
{
    public function all()
    {
        $query = Permission::query()->orderBy('created_at', 'desc');
        $query->when(request()->has('q'), function ($query) {
            $searchTerm = "%" . request()->q . "%";
            $query->where(function ($query) use ($searchTerm) {
                $query->where('title', 'LIKE', $searchTerm)
                    ->orWhere('name', 'LIKE', $searchTerm);
            });
        });
        return $query->paginate();
    }
    public function getPortalPermissions()
    {
        $query = Permission::query()
            ->with('children')
            ->orderBy('created_at', 'desc')
            ->where('is_portal', true)
            ->whereNull('parent_id');
        return $query->get();
    }


    public function select($q)
    {
        $query =  Permission::select('id', 'title')->orderBy('created_at', 'desc');
        $query->when(request()->has('q'), function ($query) use ($q) {
            $query->where('title', 'LIKE', "%" . $q . "%")
                ->orWhere('name', 'LIKE', "%" . $q . "%");
        });
        return $query->get();
    }

    public function getParents($q)
    {
        $query =  Permission::select('id', 'title')->whereNull('parent_id')->with('children')->orderBy('created_at', 'desc');
        $query->when(request()->has('q'), function ($query) use ($q) {
            $query->where('title', 'LIKE', "%" . $q . "%")
                ->orWhere('name', 'LIKE', "%" . $q . "%");
        });
        return $query->get();
    }

    public function get()
    {
        $roles = Permission::query()->get();
        return $roles;
    }

    public function show($id)
    {
        $role = $this->find($id, "id");
        return $role;
    }

    public function groups()
    {
        $roles = Permission::query()->whereNull('parent_id')->with('children')->get();
        return $roles;
    }


    public function find($value, $condition = "id")
    {
        return Permission::query()->where($condition, $value)->first();
    }

    public function create($data)
    {
        return Permission::query()->create($data);
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
