<?php

namespace Modules\Project\Transformers\v1\App\Portal;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectLandingPageResource extends JsonResource
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
            'code' => $this->code,
            'description' => $this->description,
            'is_common_access' => $this->is_common_access,
            'status' => $this->status,
            'create_at' =>  formatGregorian($this->created_at, '%A, %d %B'),

        ];
    }
}
