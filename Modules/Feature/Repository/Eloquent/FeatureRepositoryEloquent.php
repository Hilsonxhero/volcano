<?php

namespace Modules\Feature\Repository\Eloquent;

use Modules\Feature\Entities\Feature;
use Modules\Feature\Enums\FeatureStatus;
use Modules\Service\Enums\ServiceStatus;
use Modules\Feature\Repository\Contracts\FeatureRepository;

class FeatureRepositoryEloquent implements FeatureRepository
{
    public function all()
    {
        $query = Feature::query()->orderBy('created_at', 'desc');
        $query->when(request()->has('q'), function ($query) {
            $searchTerm = "%" . request()->q . "%";
            $query->where(function ($query) use ($searchTerm) {
                $query->where('title', 'LIKE', $searchTerm)
                    ->orWhere('description', 'LIKE', $searchTerm);
            });
        });
        return $query->paginate();
    }
    public function takeActiveFeatures()
    {
        $features = Feature::query()->orderByDesc('created_at')->where('status', FeatureStatus::ACTIVE->value)->get();
        return $features;
    }

    public function getPromotionServices()
    {
        $services = Feature::query()->where('status', ServiceStatus::ACTIVE->value)->where('is_promotion', true)->take(4)->get();
        return $services;
    }

    public function getMainServices()
    {
        $services = Feature::query()->where('status', ServiceStatus::ACTIVE->value)->where('is_promotion', false)->take(6)->get();
        return $services;
    }

    public function find($value, $condition = "id")
    {
        return Feature::query()->where($condition, $value)->first();
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
        $service = Feature::query()->create($data);
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
