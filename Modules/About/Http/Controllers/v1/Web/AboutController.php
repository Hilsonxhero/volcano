<?php

namespace Modules\About\Http\Controllers\v1\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\About\Entities\About;
use Modules\About\Transformers\AboutResource;
use Modules\Common\Services\ApiService;


class AboutController extends Controller
{
    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show()
    {
        $variables = aboutRepo()->all();
        return  AboutResource::collection($variables);
    }
}
