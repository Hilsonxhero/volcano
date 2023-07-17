<?php

namespace Modules\Project\Transformers\v1\Management;

use Illuminate\Http\Resources\Json\JsonResource;


class ProjectPageResource extends JsonResource
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
            'title' => $this->title,
            'name' => $this->name,
            'status' => $this->status,
            'parent' => new ProjectPageResource($this->parent),
            'create_at' =>  formatGregorian($this->created_at, '%A, %d %B'),

        ];
    }
}
