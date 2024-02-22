<?php

namespace Modules\Project\Entities;

use Modules\User\Entities\User;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class BoardCard extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        "title",
        "description",
        "short_link",
        "status",
        "position",
        "board_list_id",
        "user_id",
    ];

    public function board_list()
    {
        return $this->belongsTo(BoardList::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // protected static function newFactory()
    // {
    //     return \Modules\Project\Database\factories\BoardCardFactory::new();
    // }

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
}
