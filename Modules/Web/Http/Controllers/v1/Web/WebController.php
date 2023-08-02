<?php

namespace Modules\Web\Http\Controllers\v1\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Article\Transformers\Web\ArticleResource;
use Modules\Common\Services\ApiService;
use Modules\Feature\Transformers\Web\FeatureResource;
use Modules\Service\Transformers\Web\ServiceResource;

class WebController extends Controller
{
    public function init()
    {
        $promotion_services = serviceRepo()->getPromotionServices();
        $main_services = serviceRepo()->getMainServices();
        $features = featureRepo()->takeActiveFeatures();
        $articles = ArticleRepo()->takeActiveArticles();
        ApiService::_success(
            array(
                'promotion_services' => ServiceResource::collection($promotion_services),
                'main_services' => ServiceResource::collection($main_services),
                'features' => FeatureResource::collection($features),
                'articles' => ArticleResource::collection($articles)
            )
        );
    }
}
