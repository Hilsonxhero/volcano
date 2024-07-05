<?php

namespace Modules\Auth\Http\Controllers\v1\App\Auth\Otp;

use Exception;
use Illuminate\Http\Request;
use Modules\Sms\Facades\Sms;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Melipayamak\MelipayamakApi;
use Modules\User\Entities\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cookie;
use Modules\Common\Services\ApiService;
use GuzzleHttp\Exception\ClientException;
use Modules\User\Events\UserAuthenticatied;
use Illuminate\Support\Facades\Notification;
use Modules\Auth\Services\VerifyCodeService;
use Modules\User\Transformers\v1\App\UserResource;
use Modules\Auth\Notifications\v1\App\VerifyMailNotification;
use Modules\Auth\Notifications\v1\App\VerifyPhoneNotification;
use Modules\Sms\Services\SendSmsService;

class OtpAuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => ['required'],
        ]);

        $username = $request->input('username');

        $user = User::query()->where('email', $username)->first();

        $has_exists = VerifyCodeService::has($username);

        if (!$has_exists) {
            $code = VerifyCodeService::generate();
            VerifyCodeService::destroy($username);
            $ttl = VerifyCodeService::store($username, $code);
        } else {
            $ttl = $has_exists;
            $code = $has_exists->code;
        }


        Notification::route('mail', null)
            ->notify(new VerifyMailNotification($username, $code));


        // Notification::route('sms', null)
        //     ->notify(new VerifyPhoneNotification($username, $code));




        return  ApiService::_success([
            'username' => $username,
            'has_account' => !!$user,
            'login_method' => 'otp',
            'ttl' => Carbon::parse($ttl->ttl)->DiffInSeconds(now())
        ]);
    }

    public function login(Request $request)
    {
        $username = $request->input('username');

        $code = $request->input('code');

        $status = VerifyCodeService::check($username, $code);

        if (!$status) {
            ApiService::_throw(trans('response.auth.invalid_code'), 200);
        }

        $user = User::where('email', $username)->first();

        if (!$user) {
            $user = User::create([
                'username' => $username,
                'email' => $username,
            ]);
        }

        try {

            $token = $user->createToken('accessToken')->accessToken;

            Cookie::queue(
                'access_token',
                $token,
                45000,
                null,
                null,
                false,
                true,
                false,
                'Strict'
            );

            $request->headers->add([
                'Authorization' => 'Bearer ' . $token
            ]);

            event(new UserAuthenticatied($user));

            return ApiService::_success([
                'access_token' => $token,
                "success" => true
            ]);
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            ApiService::_response("Something went wrong on the server.", $e->getCode());
        }
    }

    public function init(Request $request)
    {
        return new UserResource(auth()->user());
        return auth()->user();
    }

    public function logout(Request $request)
    {
        auth()->user()->token()->revoke();

        $cookie = cookie()->forget('access_token');

        Cookie::queue(
            $cookie
        );

        ApiService::_success(trans('response.responses.200'));
    }
}
