<?php

namespace Modules\Project\Policies;

use Modules\User\Entities\User;
use Modules\Project\Entities\BoardMember;
use Illuminate\Auth\Access\HandlesAuthorization;

class BoardPolicy
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
        $belongsToBoard = $user->projects()->where('id', $project)->exists();
        if ($belongsToBoard) {
            return true;
        }
        return $user->hasAnyPermission(['portal_boards_management_show', 'portal_boards_management_index']);
    }

    public function show(User $user, $board)
    {
        $belongsToBoard = $user->boards()->where('board_id', $board->id)->where('status', "confirmed")->exists();
        if ($belongsToBoard) {
            return true;
        }
        $hasPermission = false;

        $member  = $board->project->members()->where('user_id', $user->id)->first();
        $permissions = ["portal_boards_management_owner"];
        if (!is_null($member->role_id)) {
            $permission_names = $member->role->permissions()->pluck('name')->toArray();

            $hasPermission = collect($permission_names)->some(function ($permission) use ($permissions) {
                return in_array($permission, $permissions);
            });
        }


        return $hasPermission;



        // return $user->hasAnyPermission(['portal_boards_management_show', 'portal_boards_management_index','portal_boards_management_owner']);
    }
}
