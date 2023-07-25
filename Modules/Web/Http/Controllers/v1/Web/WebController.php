<?php

namespace Modules\Web\Http\Controllers\v1\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\Service\Transformers\Web\ServiceResource;

class WebController extends Controller
{
    public function init()
    {
        $promotion_services = serviceRepo()->getPromotionServices();
        $main_services = serviceRepo()->getMainServices();
        ApiService::_success(
            array(
                'promotion_services' => ServiceResource::collection($promotion_services),
                'main_services' => ServiceResource::collection($main_services),
            )
        );
    }
}
