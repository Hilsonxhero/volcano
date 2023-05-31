<?php

namespace Modules\Auth\Http\Controllers\v1\App\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\User\Entities\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cookie;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Exception\ClientException;
use Modules\User\Events\UserAuthenticatied;

class GithubAuthController extends Controller
{

    public function redirect(Request $request)
    {
        $url =  Socialite::driver('github')->stateless()->redirect()->getTargetUrl();
        return $url;
    }
    public function callback(Request $request)
    {
        try {
            $auth_user = Socialite::driver("github")->stateless()->user();
        } catch (ClientException $exception) {
            return response()->json(['error' => 'Invalid credentials provided.'], 422);
        }

        $user = User::where('email', $auth_user->email)->first();

        if (!$user) {
            $user = User::create([
                'username' => $auth_user->nickname,
                'email' => $auth_user->email,
            ]);
        }

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

        return $token;
    }
}
