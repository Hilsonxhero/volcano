<?php

namespace Modules\Setting\Transformers\Management;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
