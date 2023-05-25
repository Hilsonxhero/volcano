<?php

namespace Modules\User\Repository\v1\App;


use App\Services\ApiService;
use Modules\User\Entities\User;
use Modules\State\Entities\State;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Project\Entities\Project;
use Modules\User\Entities\Address;

class UserRepository implements UserRepositoryInterface
{

    public function find($value, $condition = "id")
    {
        return User::query()->where($condition, $value)->first();
    }
}
