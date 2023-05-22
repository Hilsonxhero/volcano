<?php

namespace Modules\Auth\Http\Controllers\v1\App\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Exception\ClientException;

class GoogleAuthController extends Controller
{

    public function redirect(Request $request)
    {
        $url =  Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
        return $url;
    }


    public function callback(Request $request)
    {
        try {
            $user = Socialite::driver("google")->stateless()->user();
        } catch (ClientException $exception) {
            return response()->json(['error' => 'Invalid credentials provided.'], 422);
        }
        return $user;
    }
}
