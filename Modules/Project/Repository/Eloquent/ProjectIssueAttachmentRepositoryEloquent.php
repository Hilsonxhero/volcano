<?php

namespace Modules\Project\Repository\Eloquent;

use Modules\Project\Repository\Contracts\ProjectIssueAttachmentRepository;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProjectIssueAttachmentRepositoryEloquent implements ProjectIssueAttachmentRepository
{
    public function find($value, $condition = "id")
    {
        return Media::query()->where($condition, $value)->first();
    }

    public function delete($id)
    {
        $media = $this->find($id, 'id');
        $media->delete();
        return true;
    }
}
