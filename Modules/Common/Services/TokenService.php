<?php

namespace Modules\Common\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class TokenService
{



    protected $hasher;



    /**
     * The hashing key.
     *
     * @var string
     */
    private static $hashKey;

    /**
     * The number of seconds a token should last.
     *
     * @var int
     */
    protected static $expires;

    /**
     * Minimum number of seconds before re-redefining the token.
     *
     * @var int
     */
    protected $throttle;

    public function __construct(
        $expires = 20000,
        $throttle = 60
    ) {
        $this->hasher = config('app.key');
        $this->hashKey = app('hash');
        $this->expires = $expires * 60;
        $this->throttle = $throttle;
    }

    /**
     * Create a new token for the user.
     *
     * @return string
     */
    public static function create()
    {
        return hash_hmac('sha256', Str::random(40), self::$hashKey);
    }


    public static function tokenExpired($createdAt)
    {
        return Carbon::parse($createdAt)->addSeconds(self::$expires)->isPast();
    }
}
