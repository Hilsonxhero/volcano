<?php

namespace Modules\RolePermissions\Transformers\v1\App\Portal;

use Modules\RolePermissions\Fields\RoleFields;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\RolePermissions\Transformers\v1\App\Portal\RoleResource as PortalRoleResource;

class RoleResource extends JsonResource
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
            RoleFields::ID          => $this->{RoleFields::ID},
            RoleFields::NAME         => $this->{RoleFields::NAME},
            RoleFields::TITLE       => $this->{RoleFields::TITLE},
            RoleFields::PARENT_ID   => $this->{RoleFields::PARENT_ID},
            RoleFields::PARENT_NAME => $this->parent?->{RoleFields::TITLE},
            // RoleFields::CHILDREN    => RoleResource::collection($this->children),
            'permissions' => $this->permissions()->pluck('id'),
            'permission_names' => $this->permissions()->pluck('name'),
        ];
    }
}
