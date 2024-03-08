<?php

namespace Modules\Project\Transformers\v1\App\Portal\Board;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Transformers\v1\App\UserResource;

class BoardMemberConfirmationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'board_id' => $this->board_id,
            'email' => $this->email,
            'user' => new UserResource($this->user),
            'inviter' => $this->inviter,
            'board' => new BoardResource($this->board),
            'status' => $this->status,
            'role' => $this->role,
            'token' => $this->token,
        ];
    }
}
