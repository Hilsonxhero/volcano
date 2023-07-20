<?php

namespace Modules\User\Http\Controllers\v1\App\Profile;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Common\Services\ApiService;
use Modules\Auth\Services\VerifyCodeService;

class UpdatePhoneController extends Controller
{
    /**
     * Request for update phone.
     * @param Request $request
     * @return Response
     */
    public function request(Request $request)
    {
        $user = auth()->user();
        $phone = $request->input('phone');
        if ($user->phone == $phone) {
            ApiService::_success(trans("response.responses.200"));
        }
        ApiService::Validator($request->all(), [
            'phone' => ['required', 'unique:users,phone']
        ]);
        $has_exists = VerifyCodeService::has($phone);
        if (!$has_exists) {
            $code = VerifyCodeService::generate();
            VerifyCodeService::destroy($phone);
            $ttl = VerifyCodeService::store($phone, $code);
        } else {
            $ttl = $has_exists;
            $code = $has_exists->code;
        }
        ApiService::_success([
            'phone' => $phone,
            'ttl' => Carbon::parse($ttl->ttl)->DiffInSeconds(now())
        ]);
        ApiService::_success(trans('response.responses.200'));
    }

    /**
     * Confirm the user mobile.
     * @param Request $request
     * @return Response
     */
    public function confirm(Request $request)
    {
        ApiService::Validator($request->all(), [
            'phone' => ['required', 'unique:users,phone'],
            'code' => ['required']
        ]);
        $user = auth()->user();
        $phone = $request->input('phone');
        $code = $request->input('code');
        $status = VerifyCodeService::check($phone, $code);
        if (!$status) {
            ApiService::_throw(trans('response.auth.invalid_code'), 200);
        }
        userRepo()->update($user->id, ['phone' => $phone]);
        ApiService::_success(trans('response.responses.200'));
    }
}
