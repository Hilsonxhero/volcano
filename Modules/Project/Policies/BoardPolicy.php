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
        // $hasPermission  =  $user->hasPermissionTo("portal_boards_management_show");
        $belongsToBoard = $user->boards()->where('board_id', $board->id)->where('status', "confirmed")->exists();
        // $user_board = $board->user_id == $user->id;
        // return ($hasPermission && $belongsToBoard) || $user_board;
        return $belongsToBoard;
    }
}
