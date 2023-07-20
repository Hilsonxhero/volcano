<?php

namespace Modules\User\Http\Controllers\v1\Management;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;
use Modules\User\Enums\UserStatus;
use Illuminate\Validation\Rules\Enum;
use Modules\Common\Services\ApiService;
use Modules\User\Http\Requests\v1\Management\User\UserRequest;
use Modules\User\Transformers\v1\Management\UserResource;

class UserController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $users = userRepo()->all();
        $users_collection = UserResource::collection($users);
        ApiService::_success(
            array(
                'users' => $users_collection,
                'pager' => array(
                    'pages' => $users_collection->lastPage(),
                    'total' => $users_collection->total(),
                    'current_page' => $users_collection->currentPage(),
                    'per_page' => $users_collection->perPage(),
                )
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */

    public function select(Request $request)
    {
        $users = userRepo()->select($request->q);
        ApiService::_success($users);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(UserRequest $request)
    {
        $data = [
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => UserStatus::ACTIVE->value
        ];
        $user = userRepo()->create($data);
        $user->roles()->detach();
        $user->assignRole($request->role);
        if ($request->filled('avatar')) {
            $user->clearMediaCollectionExcept();
            base64($request->avatar) ? $user->addMediaFromBase64($request->avatar)->toMediaCollection()
                : $user->addMedia($request->avatar)->toMediaCollection();
        }

        ApiService::_success($user);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $user = userRepo()->show($id);

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(UserRequest $request, $id)
    {
        $data = [
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status,
        ];
        $user = userRepo()->update($id, $data);
        $user->roles()->detach();
        $user->assignRole($request->role);
        if ($request->avatar) {
            $user->clearMediaCollectionExcept();
            base64($request->avatar) ? $user->addMediaFromBase64($request->avatar)->toMediaCollection()
                : $user->addMedia($request->avatar)->toMediaCollection();
        }
        ApiService::_success(trans('response.responses.200'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        userRepo()->delete($id);
        ApiService::_success(trans('response.responses.200'));
    }
}
