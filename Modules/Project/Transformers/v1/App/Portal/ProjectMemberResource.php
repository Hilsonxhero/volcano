<?php

namespace Modules\Project\Transformers\v1\App\Portal;

use Illuminate\Http\Resources\Json\JsonResource;


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
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
        ];
    }
}
