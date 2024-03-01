<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;

class BoardMember extends Model
{
    use HasFactory;

    protected $fillable = [
        "email",
        "token",
        "user_id",
        "inviter_id",
        "board_id",
        "role",
        "status",
    ];

    public function board()
    {
        return $this->belongsTo(Board::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function inviter()
    {
        return $this->belongsTo(User::class, "inviter_id", "id");
    }
}
