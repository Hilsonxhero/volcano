<?php

namespace Modules\Project\Entities;

use Modules\User\Entities\User;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class ProjectIssue extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'project_id',
        'project_issue_status_id',
        'project_tracker_id',
        'creator_id',
        'assigned_to_id',
        'title',
        'description',
        'note',
        'start_date',
        'end_date',
        'estimated_hours',
        'done_ratio',
        'status',
        'project_priority_id',
        'parent_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
    public function tracker()
    {
        return $this->belongsTo(ProjectTracker::class, 'project_tracker_id', 'id');
    }
    public function issue_status()
    {
        return $this->belongsTo(ProjectIssueStatus::class, 'project_issue_status_id', 'id');
    }
    public function creator()
    {
        return $this->belongsTo(User::class);
    }
    public function assigned()
    {
        return $this->belongsTo(User::class, 'assigned_to_id', 'id');
    }
    public function parent()
    {
        return $this->belongsTo(ProjectIssue::class);
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function project_priority()
    {
        return $this->belongsTo(ProjectPriority::class);
    }

    protected function attachmentMedia(): Attribute
    {
        return Attribute::make(
            get: function () {
                $attachment_items = $this->getMedia();
                $attachments = array();
                foreach ($attachment_items as $key => $mediaItem) {
                    array_push($attachments, ['path' => $mediaItem->getUrl(), 'id' => $mediaItem->id]);
                }
                return $attachments;
            }
        );
    }

    // protected static function newFactory()
    // {
    //     return \Modules\Project\Database\factories\ProjectIssueFactory::new();
    // }
}
