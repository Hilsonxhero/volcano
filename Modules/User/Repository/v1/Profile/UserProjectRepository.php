<?php

namespace Modules\User\Repository\v1\Profile;


use App\Services\ApiService;
use Modules\User\Entities\User;

use Modules\State\Entities\State;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Project\Entities\Project;
use Modules\User\Entities\Address;

class UserProjectRepository implements UserProjectRepositoryInterface
{

    public function get()
    {
        $user = auth()->user();
        return $user->projects()->OrderByDesc('created_at');
    }

    public function store($data)
    {
        return Project::query()->create($data);
    }
}
