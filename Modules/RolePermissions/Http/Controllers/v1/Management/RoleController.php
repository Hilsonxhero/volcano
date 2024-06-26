<?php

namespace Modules\RolePermissions\Http\Controllers\v1\Management;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\RolePermissions\Http\Requests\v1\Management\Role\RoleRequest;
use Modules\RolePermissions\Transformers\v1\Management\RoleResource;

class RoleController extends Controller
{


    public function index()
    {
        $roles = roleRepo()->all();
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
        $roles = roleRepo()->select($request->q);
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
        $role = roleRepo()->create($data);
        $role->syncPermissions($request->permissions);
        ApiService::_success($role);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $role = roleRepo()->show($id);
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
        $role = roleRepo()->update($id, $data);
        $role->syncPermissions($request->permissions);
        ApiService::_success(trans('response.responses.200'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        roleRepo()->delete($id);
        ApiService::_success(trans('response.responses.200'));
    }
}
