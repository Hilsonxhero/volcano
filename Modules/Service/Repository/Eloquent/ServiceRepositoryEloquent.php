<?php

namespace Modules\Service\Repository\Eloquent;

use Modules\Service\Entities\Service;
use Modules\Service\Repository\Contracts\ServiceRepository;

class ServiceRepositoryEloquent implements ServiceRepository
{
    public function all()
    {
        $query = Service::query()->orderBy('created_at', 'desc');
        $query->when(request()->has('q'), function ($query) {
            $searchTerm = "%" . request()->q . "%";
            $query->where(function ($query) use ($searchTerm) {
                $query->where('title', 'LIKE', $searchTerm)
                    ->orWhere('description', 'LIKE', $searchTerm);
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
        $service = $this->find($id, 'id');
        $service->update($data);
        return $service;
    }
    public function create($data)
    {
        $service = Service::query()->create($data);
        return $service;
    }
    public function delete($id)
    {
        $service = $this->find($id);
        $service->clearMediaCollectionExcept();
        $service->delete();
        return $service;
    }
}
