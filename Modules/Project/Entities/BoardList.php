<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;
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
}
