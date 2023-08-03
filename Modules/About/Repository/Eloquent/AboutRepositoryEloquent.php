<?php

namespace Modules\About\Repository\Eloquent;

use Modules\About\Entities\About;
use Modules\About\Repository\Contracts\AboutRepository;

class AboutRepositoryEloquent implements AboutRepository
{
    public function all()
    {
        return About::all()->keyBy->name;
    }
    public function insert($data)
    {
        return About::query()->insert($data);
    }
    public function update($id, $data)
    {
    }
    public function show($id)
    {
    }
    public function find($name)
    {
        $variable = About::query()->where('name', $name)->first();
        return $variable;
    }
}
