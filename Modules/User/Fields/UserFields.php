<?php

namespace Modules\User\Fields;

/*
|--------------------------------------------------------------------------
| Model Const FIELDS
|--------------------------------------------------------------------------
*/

class UserFields
{
    const ID                     = 'id';
    const USERNAME               = 'username';
    const EMAIL                  = 'email';
    const PHONE                  = 'phone';
    const IP                     = 'ip';
    const POINT                  = 'point';
    const GENDER                 = 'gender';
    const IS_SUPERUSER           = 'is_superuser';
    const BIO                    = 'bio';
    const EMAIL_VERIFIED_AT      = 'email_verified_at';
    const PASSWORD               = 'password';
    const PASSWORD_CONFIRMATION  = self::PASSWORD . '_confirmation';
    const STATUS                 = 'status';
    const CREATED_AT             = 'created_at';
    const ROLES                  = 'roles';
}
