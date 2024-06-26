<?php

namespace Modules\Project\Transformers\v1\App\Portal;

use Illuminate\Http\Resources\Json\JsonResource;


class ProjectIssueResource extends JsonResource
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
            'note' => $this->note,
            'project_id' => $this->project_id,
            'tracker' => $this->tracker,
            'issue_status' => $this->issue_status,
            'creator' => $this->creator,
            'assigned' => $this->assigned,
            'parent_id' => $this->parent_id,
            'parent' => $this->parent,
            // 'children' =>  ProjectIssueResource::collection($this->children),
            'project_priority' => $this->project_priority,
            'status' => $this->status,
            'estimated_hours' => $this->estimated_hours,
            'done_ratio' => $this->done_ratio,
            'attachments' => $this->attachment_media,
            'start_date' => formatGregorian($this->start_date, 'Y/m/d'),
            'end_date' => formatGregorian($this->end_date, 'Y/m/d'),
            'total_hours' => $this->totalHours
        ];
    }
}
