<?php

namespace Modules\RolePermissions\Policies;

use Modules\User\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function manage(User $user, $project)
    {
        $portal = projectRepo()->find($project);

        if ($portal->user_id == $user->id) {
            return true;
        }

        $access = $user->memberships()->where('project_id', $project)->exists();
        if (!$access) {
            return false;
        }
        $user_role = $user->roles()->where('project_id', $project)->first();
        return $user_role->hasAnyPermission(["portal_users_management_index", "portal_project_management_index"]);
        // return $user->hasAnyPermission(['portal_users_management_index', 'portal_project_management_index']);
    }
}
