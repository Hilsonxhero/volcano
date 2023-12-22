<?php

namespace Modules\Project\Transformers\v1\App\Portal;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectTimeEntryResource extends JsonResource
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
            'description' => $this->description,
            'spent_on' =>  formatGregorian($this->spent_on, "Y/m/d"),
            'hours' => $this->hours,
            'title' => $this->title,
            'user' => $this->user,
            'project' => $this->project,
            'issue' => $this->issue,
            'category' => $this->category,

        ];
    }
}
