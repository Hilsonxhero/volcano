<?php

namespace Modules\Project\Policies;

use Modules\User\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PortalPolicy
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
        $access = $user->memberships()->where('project_id', $project)->exists();
        if ($access) {
            return true;
        }
        return false;
    }
}
