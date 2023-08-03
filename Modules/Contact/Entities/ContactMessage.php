<?php

namespace Modules\Contact\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'content',
        'status',
    ];

    // protected static function newFactory()
    // {
    //     return \Modules\Contact\Database\factories\ContactMessageFactory::new();
    // }
}
