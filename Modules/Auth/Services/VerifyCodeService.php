<?php

namespace Modules\Auth\Services;


use Modules\Auth\Entities\VerificationCode;

class VerifyCodeService
{
    private static $min = 10000;
    private static $max = 99999;

    public static function generate()
    {
        return random_int(self::$min, self::$max);
    }

    public static function store($username, $code)
    {

        return VerificationCode::query()->create([
            'username' => $username,
            'code' => $code,
            'ttl' => now()->addMinutes(2),
            'expired_at' => now()->addMinutes(2)
        ]);
    }

    public static function get($username, $code)
    {
        return VerificationCode::where('username', $username)->first()->code;
    }

    public static function has($username)
    {
        return VerificationCode::where('username', $username)->where('expired_at', '>', now())->first();
    }

    public static function destroy($username)
    {
        return VerificationCode::where('username', $username)->delete();
    }

    public static function check($username, $code)
    {
        $exists = self::has($username);
        if ($exists && $exists->code == $code) {
            self::destroy($username);
            return true;
        }

        return false;
    }
}
