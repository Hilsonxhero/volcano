<?php

namespace Modules\RolePermissions\Http\Controllers\v1\Management;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\RolePermissions\Http\Requests\v1\Management\Role\RoleRequest;
use Modules\RolePermissions\Transformers\v1\Management\RoleResource;

class PermissionController extends Controller
{


    public function index()
    {
        $permissions = permissionRepo()->all();
        $permissions_collection = RoleResource::collection($permissions);
        ApiService::_success(
            array(
                'permissions' => $permissions_collection,
                'pager' => array(
                    'pages' => $permissions_collection->lastPage(),
                    'total' => $permissions_collection->total(),
                    'current_page' => $permissions_collection->currentPage(),
                    'per_page' => $permissions_collection->perPage(),
                )
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */

    public function getParents(Request $request)
    {
        $permissions = permissionRepo()->getParents($request->q);
        ApiService::_success($permissions);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */

    public function select(Request $request)
    {
        $permissions = permissionRepo()->select($request->q);
        ApiService::_success($permissions);
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
        $role = permissionRepo()->create($data);
        ApiService::_success($role);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $role = permissionRepo()->show($id);
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
        $role = permissionRepo()->update($id, $data);
        ApiService::_success(trans('response.responses.200'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        permissionRepo()->delete($id);
        ApiService::_success(trans('response.responses.200'));
    }
}
