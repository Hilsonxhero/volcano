<?php

namespace Modules\User\Http\Controllers\v1\Management;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;
use Modules\User\Enums\UserStatus;
use Illuminate\Validation\Rules\Enum;
use Modules\Common\Services\ApiService;
use Modules\User\Transformers\v1\Management\UserResource;
use Modules\User\Repository\v1\App\UserRepositoryInterface;

class UserController extends Controller
{

    /**
     * @var UserRepositoryInterface
     */
    private $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }


    public function index()
    {
        $users = $this->userRepo->all();
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
        $users = $this->userRepo->select($request->q);
        ApiService::_success($users);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        ApiService::Validator($request->all(), [
            'title' => ['required'],
            'description' => ['required'],
            'link' => ['nullable'],
            'parent' => ['nullable', 'exists:users,id'],
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
            'parent_id' => $request->parent,
            'status' => UserStatus::ACTIVE->value
        ];
        $user = $this->userRepo->create($data);

        if ($request->filled('image')) {
            base64($request->image) ? $user->addMediaFromBase64($request->image)->toMediaCollection()
                : $user->addMedia($request->image)->toMediaCollection();
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
        $user = $this->userRepo->show($id);

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        ApiService::Validator($request->all(), [
            'username' => ['required'],
            'email' => ['required', Rule::unique('users', 'email')->ignore(request()->id)],
            'phone' => ['nullable', Rule::unique('users', 'phone')->ignore(request()->id)],
            'role' => ['required', 'exists:roles,id'],
            'status' => ['required', new Enum(UserStatus::class)],
        ]);
        $data = [
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status,
        ];
        $user = $this->userRepo->update($id, $data);
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
        $this->userRepo->delete($id);
        ApiService::_success(trans('response.responses.200'));
    }
}
