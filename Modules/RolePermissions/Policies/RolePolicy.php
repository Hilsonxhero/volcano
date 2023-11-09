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


    public function manage(User $user)
    {
        return $user->hasAnyPermission(['portal_users_management', 'portal_project_management_index']);
    }
}
