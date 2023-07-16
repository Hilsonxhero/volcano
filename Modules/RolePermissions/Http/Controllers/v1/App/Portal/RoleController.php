<?php

namespace Modules\RolePermissions\Http\Controllers\v1\App\Portal;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\RolePermissions\Transformers\v1\App\Portal\RoleResource;
use Modules\RolePermissions\Repository\v1\App\Portal\RoleRepositoryInterface;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $roles = roleRepo()->groups();
        $roles = RoleResource::collection($roles);
        return ApiService::_success($roles);
    }
}
