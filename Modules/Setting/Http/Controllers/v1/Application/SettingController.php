<?php

namespace Modules\Setting\Http\Controllers\v1\Application;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\Setting\Transformers\Management\SettingResource;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {

        $settings = settingRepo()->all();
        $settings = SettingResource::collection($settings);
        return ApiService::_success($settings);
    }
}
