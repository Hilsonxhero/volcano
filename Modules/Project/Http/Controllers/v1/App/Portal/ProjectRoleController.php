<?php

namespace Modules\Project\Http\Controllers\v1\App\Portal;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\Project\Http\Requests\v1\App\ProjectRoleRequest;
use Modules\RolePermissions\Transformers\v1\App\Portal\RoleResource;

class ProjectRoleController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, $id)
    {
        $roles = roleRepo()->get($id);
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
    public function store(ProjectRoleRequest $request, $id)
    {
        $data = [
            'title' => $request->title,
            'name' => $request->name,
            'project_id' => $id,
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
    public function show($project, $id)
    {
        $role = roleRepo()->show($id);
        $resource = new RoleResource($role);
        ApiService::_success($resource);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(ProjectRoleRequest $request, $project, $id)
    {
        $data = array(
            'title' => $request->title,
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'guard' => 'api',
            'project_id' => $project,
        );
        $role = roleRepo()->update($id, $data);
        ApiService::_success(trans('response.responses.200'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($project, $id)
    {
        $role = roleRepo()->delete($id);
        ApiService::_success(trans('response.responses.200'));
    }
}
