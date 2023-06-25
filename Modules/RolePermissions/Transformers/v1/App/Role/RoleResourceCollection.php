<?php

namespace Modules\RolePermissions\Transformers\v1\App\Role;

use Illuminate\Http\Request;
use Modules\RolePermissions\Fields\RoleFields;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RoleResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(fn ($parent) => [
                RoleFields::ID    => $parent->{RoleFields::ID},
                RoleFields::KEY   => $parent->{RoleFields::NAME},
                RoleFields::TITLE => $parent->{RoleFields::TITLE},

                RoleFields::PERMISSIONS => $parent->children->map(fn ($role) => [
                    RoleFields::ID    => $role->{RoleFields::ID},
                    RoleFields::KEY   => $role->{RoleFields::NAME},
                    RoleFields::TITLE => $role->{RoleFields::TITLE},
                ])
            ])
        ];
    }
}
