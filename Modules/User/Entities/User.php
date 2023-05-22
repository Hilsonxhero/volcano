<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'username', 'ip', 'nullable', 'email', 'phone', 'email_verified_at',
        'remember_token', 'password', 'status', 'job', 'gender', 'is_superuser',
    ];

    protected static function newFactory()
    {
        return \Modules\User\Database\factories\UserFactory::new();
    }
}
