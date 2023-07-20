<?php

namespace Modules\User\Http\Controllers\v1\App\Profile;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;

class UpdateProfileController extends Controller
{
    /**
     * Update the user username.
     * @param Request $request
     * @return Response
     */
    public function username(Request $request)
    {
        ApiService::Validator($request->all(), [
            'username' => ['required']
        ]);
        $user = auth()->user();
        userRepo()->update($user->id, ['username' => $request->username]);
        ApiService::_success(trans('response.responses.200'));
    }


    /**
     * Update the user profile photo.
     * @param Request $request
     * @return Response
     */
    public function avatar(Request $request)
    {
        $user = auth()->user();
        ApiService::Validator($request->all(), [
            'avatar' => ['required', 'file']
        ]);
        if ($user->getFirstMediaUrl('avatar')) {
            $user->clearMediaCollection('avatar');
        }
        $user->addMedia($request->avatar)->toMediaCollection('avatar');
        ApiService::_success(trans('response.responses.200'));
    }
}
