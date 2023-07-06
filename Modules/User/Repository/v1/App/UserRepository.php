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

    public function all()
    {
        $query = User::query()->orderBy('created_at', 'desc');
        $query->when(request()->has('q'), function ($query) {
            $searchTerm = "%" . request()->q . "%";
            $query->where(function ($query) use ($searchTerm) {
                $query->where('username', 'LIKE', $searchTerm)
                    ->orWhere('email', 'LIKE', $searchTerm);
            });
        });
        return $query->paginate();
    }

    public function select($q)
    {
        $query =  User::select('id', 'username')->orderBy('created_at', 'desc');


        $query->when(request()->has('q'), function ($query) use ($q) {
            $query->where('username', 'LIKE', "%" . $q . "%");
        });

        return $query->take(25)->get();
    }


    public function find($value, $condition = "id")
    {
        return User::query()->where($condition, $value)->first();
    }

    public function show($id)
    {
        return $this->find($id, "id");
    }

    public function update($id, $data)
    {
        $user = $this->find($id, 'id');
        $user->update($data);
        return $user;
    }

    public function create($data)
    {
        $user = User::query()->create($data);
        return $user;
    }
}
