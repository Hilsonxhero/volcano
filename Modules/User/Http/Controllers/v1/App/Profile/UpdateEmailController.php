<?php

namespace Modules\User\Http\Controllers\v1\App\Profile;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\Auth\Services\VerifyCodeService;
use Modules\User\Notifications\App\VerifyMailNotification;

class UpdateEmailController extends Controller
{
    /**
     * Request for update email.
     * @param Request $request
     * @return Response
     */
    public function request(Request $request)
    {
        $user = auth()->user();
        $email = $request->input('email');
        if ($user->email == $email) {
            ApiService::_success(trans("response.responses.200"));
        }
        ApiService::Validator($request->all(), [
            'email' => ['required', 'unique:users,email']
        ]);
        $has_exists = VerifyCodeService::has($user->phone);
        if (!$has_exists) {
            $code = VerifyCodeService::generate();
            VerifyCodeService::destroy($user->phone);
            $ttl = VerifyCodeService::store($user->phone, $code);
        } else {
            $ttl = $has_exists;
            $code = $has_exists->code;
        }
        $user->notify(new VerifyMailNotification($code));
        ApiService::_success([
            'email' => $email,
            'ttl' => Carbon::parse($ttl->ttl)->DiffInSeconds(now())
        ]);
        ApiService::_success(trans('response.responses.200'));
    }

    /**
     * Confirm the user email.
     * @param Request $request
     * @return Response
     */
    public function confirm(Request $request)
    {
        ApiService::Validator($request->all(), [
            'email' => ['required', 'unique:users,email'],
            'code' => ['required']
        ]);
        $user = auth()->user();
        $email = $request->input('email');
        $code = $request->input('code');
        $status = VerifyCodeService::check($user->phone, $code);
        if (!$status) {
            ApiService::_throw(trans('response.auth.invalid_code'), 200);
        }
        userRepo()->update($user->id, ['email' => $email]);
        ApiService::_success(trans('response.responses.200'));
    }
}
