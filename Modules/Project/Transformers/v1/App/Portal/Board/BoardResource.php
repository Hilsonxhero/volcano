<?php

namespace Modules\Project\Transformers\v1\App\Portal\Board;

use Illuminate\Http\Resources\Json\JsonResource;


class BoardResource extends JsonResource
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
            'description' => $this->description,
            'short_link' => $this->short_link,
            'status' => $this->status,
            'date_last_activity' => $this->date_last_activity,
            'date_last_view' => $this->date_last_view,
            'project' => $this->project,
            'user' => $this->user,
            'members' => BoardMemberResource::collection($this->members),
        ];
    }
}
