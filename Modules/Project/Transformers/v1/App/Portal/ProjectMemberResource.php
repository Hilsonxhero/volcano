<?php

namespace Modules\Project\Transformers\v1\App\Portal;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Transformers\v1\App\UserResource;
use Modules\RolePermissions\Transformers\v1\App\Portal\RoleResource;

class ProjectMemberResource extends JsonResource
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
            'username' => $this->user->username,
            'email' => $this->user->email,
            'phone' => $this->user->phone,
            'role' => $this->user->role,
            // 'user' => new UserResource($this->user),
            'role' => new RoleResource($this->user->roles()->where('project_id', $this->project_id)->first()),
            'status' => $this->status,
            'user_id' => $this->user_id,

        ];
    }
}
