<?php

namespace Modules\Project\Transformers\v1\App\Portal\Board;

use Illuminate\Http\Resources\Json\JsonResource;


class BoardCardResource extends JsonResource
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
            'board_list_id' => $this->board_list_id,
            'status' => $this->status,
            // 'board' => new BoardResource($this->board),
        ];
    }
}
