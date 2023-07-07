<?php

namespace Modules\User\Http\Controllers\v1\App;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\User\Transformers\v1\App\UserResource;

class UserController extends Controller
{

    public function __construct()
    {
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function init(Request $request)
    {

        $user = auth()->user();

        ApiService::_success(array(
            'user' => $user ? new UserResource($user) : null,
            'is_logged_in' => !!$user,
        ));
    }
}
