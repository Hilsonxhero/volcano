<?php

namespace Modules\Setting\Repository\Eloquent;

use Modules\Setting\Entities\Setting;
use Modules\Setting\Repository\Contracts\SettingRepository;

class SettingRepositoryEloquent implements SettingRepository
{
    public function all()
    {
        return Setting::all()->keyBy->name;
    }
    public function insert($data)
    {
        return Setting::query()->insert($data);
    }
    public function update($id, $data)
    {
        $setting = $this->find($id);
        $setting->update([
            'title' => $data->title,
            'url' => $data->url,
            'type' => $data->type,
            'status' => $data->status,
            'bannerable_id' => $data->page,
            'bannerable_type' => Page::class,
        ]);

        if ($data->filled('banner')) {
            $setting->clearMediaCollectionExcept();
            base64($data->banner) ? $setting->addMediaFromBase64($data->banner)->toMediaCollection('main')
                : $setting->addMedia($data->banner)->toMediaCollection('main');
        }
        return $setting;
    }
    public function show($id)
    {
        $setting = $this->find($id);
        return $setting;
    }
    public function find($name)
    {
        $setting = Setting::query()->where('name', $name)->first();
        return $setting;
    }
}
