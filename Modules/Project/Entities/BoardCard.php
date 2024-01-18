<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;

class BoardCard extends Model
{
    use HasFactory;

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
}
