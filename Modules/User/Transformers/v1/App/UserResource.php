<?php

namespace Modules\User\Transformers\v1\App;

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
            'created_at' => formatGregorian($this->created_at, '%A, %d %B'),
            'media' => [
                'avatar' => $this->getFirstMediaUrl('avatar'),
                'thumb' => $this->getFirstMediaUrl('avatar', 'thumb'),
            ],
        );
    }
}
