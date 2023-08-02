<?php

namespace Modules\Auth\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VerificationCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'code',
        'ttl',
        'expired_at',
    ];
    public $timestamps = false;

    // protected static function newFactory()
    // {
    //     return \Modules\Auth\Database\factories\VerificationCodeFactory::new();
    // }
}
