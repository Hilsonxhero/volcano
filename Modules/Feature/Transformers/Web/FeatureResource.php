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
            'slug' => $this->slug,
            'description' => $this->description,
            'status' => $this->status,
            'media' => [
                'cover' => $this->getFirstMediaUrl('cover'),
                'icon' => $this->getFirstMediaUrl('icon')
            ],
        ];
    }
}
