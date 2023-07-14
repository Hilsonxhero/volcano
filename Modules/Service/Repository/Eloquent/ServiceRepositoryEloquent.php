<?php

namespace Modules\User\Repository\Eloquent;

use Modules\Service\Entities\Service;
use Modules\Service\Repository\Contracts\ServiceRepository;
use Modules\User\Entities\User;

class ServiceRepositoryEloquent implements ServiceRepository
{
    public function all()
    {
        $query = Service::query()->orderBy('created_at', 'desc');
        $query->when(request()->has('q'), function ($query) {
            $searchTerm = "%" . request()->q . "%";
            $query->where(function ($query) use ($searchTerm) {
                $query->where('username', 'LIKE', $searchTerm)
                    ->orWhere('email', 'LIKE', $searchTerm);
            });
        });
        return $query->paginate();
    }

    public function find($value, $condition = "id")
    {
        return Service::query()->where($condition, $value)->first();
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
        $user = Service::query()->create($data);
        return $user;
    }
}
