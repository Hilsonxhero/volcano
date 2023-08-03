<?php

namespace Modules\About\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class AboutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $option = $this->value;
        return $this->getFirstMediaUrl('main') ?: json_decode($option);
    }
}
