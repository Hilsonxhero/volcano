<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Project\Entities\BoardCard;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BoardList extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'short_link',
        'status',
        'board_id',
        'position',
    ];

    // protected static function newFactory()
    // {
    //     return \Modules\Project\Database\factories\BoardListFactory::new();
    // }


    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    public function cards()
    {
        return $this->hasMany(BoardCard::class)->orderBy('position', 'asc');
    }
}
