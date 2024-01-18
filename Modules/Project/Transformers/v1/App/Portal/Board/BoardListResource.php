<?php

namespace Modules\Project\Transformers\v1\App\Portal\Board;

use Illuminate\Http\Resources\Json\JsonResource;


class BoardListResource extends JsonResource
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
            'position' => $this->position,
            'board' => new BoardResource($this->board),
        ];
    }
}
