<?php

namespace Modules\Project\Transformers\v1\App\Portal;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Project\Entities\ProjectMembership;
use Modules\Project\Transformers\v1\App\Portal\ProjectPageResource;

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
            'id' => $this->project->id,
            'title' => $this->project->title,
            'slug' => $this->project->slug,
            'short_link' => $this->project->short_link,
            'description' => $this->project->description,
            'status' => $this->project->status,
            'pages' =>  ProjectPageResource::collection($this->project->pages),
            'date_last_activity' => $this->project->date_last_activity,
            'date_last_view' => $this->project->date_last_view,
            'create_at' =>  formatGregorian($this->project->created_at, '%A, %d %B'),
            'members' => ProjectMemberResource::collection($this->project->members)

        ];
    }
}
