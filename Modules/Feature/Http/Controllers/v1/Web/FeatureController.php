<?php

namespace Modules\Feature\Http\Controllers\v1\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\Feature\Transformers\Web\FeatureResource;

class FeatureController extends Controller
{

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $feaure = featureRepo()->show($id);
        return new FeatureResource($feaure);
    }
}
