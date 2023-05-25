<?php

namespace Modules\Project\Repository\v1\App;

use Modules\Project\Entities\Project;


class ProjectRepository implements ProjectRepositoryInterface
{
    public function find($id)
    {
        return Project::query()->where('id', $id)->first();
    }
}
