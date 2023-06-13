<?php

namespace Modules\Project\Transformers\v1\App\Portal;

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
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            // 'parent' =>  new ProjectPageResource($this->parent),
            'status' => $this->status,
            'children' => ProjectPageResource::collection($this->children),
        ];
    }
}
