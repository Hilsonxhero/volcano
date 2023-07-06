<?php

namespace Modules\User\Transformers\v1\Management;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'role' => $this->role,
            'created_at' => formatGregorian($this->created_at, '%A, %d %B'),
            'avatar' => [
                'main' => $this->getFirstMediaUrl(),
                'thumb' => $this->getFirstMediaUrl('default', 'thumb')
            ],
        );
    }
}
