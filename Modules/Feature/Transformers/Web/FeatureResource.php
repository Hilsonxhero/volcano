<?php

namespace Modules\Feature\Transformers\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class FeatureResource extends JsonResource
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
            'status' => $this->status,
            'is_promotion' => $this->is_promotion,
            'media' => [
                'main' => $this->getFirstMediaUrl('default'),
                'thumb' => $this->getFirstMediaUrl('default', 'thumb')
            ],
        ];
    }
}
