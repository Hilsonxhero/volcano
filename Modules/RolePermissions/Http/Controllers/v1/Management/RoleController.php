<?php

namespace Modules\RolePermissions\Http\Controllers\v1\Management;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\RolePermissions\Http\Requests\v1\Management\Role\RoleRequest;
use Modules\RolePermissions\Repository\v1\App\Portal\RoleRepositoryInterface;
use Modules\RolePermissions\Transformers\v1\Management\RoleResource;

class RoleController extends Controller
{
    private $roleRepo;

    public function __construct(
        RoleRepositoryInterface $roleRepo
    ) {
        $this->roleRepo = $roleRepo;
    }


    public function index()
    {
        $roles = $this->roleRepo->all();
        $roles_collection = RoleResource::collection($roles);
        ApiService::_success(
            array(
                'roles' => $roles_collection,
                'pager' => array(
                    'pages' => $roles_collection->lastPage(),
                    'total' => $roles_collection->total(),
                    'current_page' => $roles_collection->currentPage(),
                    'per_page' => $roles_collection->perPage(),
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
        $roles = $this->roleRepo->select($request->q);
        ApiService::_success($roles);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(RoleRequest $request)
    {
        $data = [
            'title' => $request->title,
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'guard' => 'api'
        ];
        $role = $this->roleRepo->create($data);
        ApiService::_success($role);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $role = $this->roleRepo->show($id);
        return new RoleResource($role);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(RoleRequest $request, $id)
    {
        $data = [
            'title' => $request->title,
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'status' => $request->status,
        ];
        $role = $this->roleRepo->update($id, $data);
        ApiService::_success(trans('response.responses.200'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->roleRepo->delete($id);
        ApiService::_success(trans('response.responses.200'));
    }
}
