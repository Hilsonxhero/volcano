<?php

namespace Modules\Project\Http\Controllers\v1\App\Portal;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\RolePermissions\Transformers\v1\App\Permission\PermissionResource;

class ProjectPermissionController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, $id)
    {
        $permissions = permissionRepo()->getPortalPermissions($id);
        $permissions_collection = PermissionResource::collection($permissions);
        ApiService::_success($permissions_collection);
    }
}
