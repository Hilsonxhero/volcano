<?php

namespace Modules\Project\Transformers\v1\App\Portal;

use Illuminate\Http\Resources\Json\JsonResource;


class ProjectInviteResource extends JsonResource
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
            'project' => $this->project,
            'user' => $this->user->username,
            'email' => $this->email,
            'role' => $this->role,
            'token' => $this->token,
        ];
    }
}
