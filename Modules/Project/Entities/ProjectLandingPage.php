<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;

class ProjectLandingPage extends Model
{
    use HasFactory;

    protected $fillable = [
        "project_id",
        "user_id",
        "title",
        "code",
        "status",
        "is_common_access",
        "description",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function children()
    {
        return $this->hasMany(ProjectPage::class, 'landing_page_id')->whereNull('parent_id');
    }
}
