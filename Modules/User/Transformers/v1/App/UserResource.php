<?php

namespace Modules\User\Transformers\v1\App;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Project\Transformers\v1\App\ProjectResource;
use Modules\RolePermissions\Transformers\v1\App\Portal\RoleResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return array(
            'id' => $this->id,
            'username' => $this->username,
            'phone' => $this->phone,
            'email' => $this->email,
            'status' => $this->status,
            'is_superuser' => $this->is_superuser,
            'point' => $this->point,
            'role' => new RoleResource($this->role),
            // 'role' => $this->role,
            'created_at' => formatGregorian($this->created_at, '%A, %d %B'),
            'media' => [
                'avatar' => $this->getFirstMediaUrl('avatar'),
                'thumb' => $this->getFirstMediaUrl('avatar', 'thumb'),
            ],
            'projects' => ProjectResource::collection($this->memberships)
        );
    }
}
