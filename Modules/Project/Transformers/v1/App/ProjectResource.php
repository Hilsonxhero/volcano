<?php

namespace Modules\Project\Transformers\v1\App;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'short_link' => $this->short_link,
            'description' => $this->description,
            'user' => $this->user,
            'date_last_activity' => $this->date_last_activity,
            'date_last_view' => $this->date_last_view,
        ];
    }
}
