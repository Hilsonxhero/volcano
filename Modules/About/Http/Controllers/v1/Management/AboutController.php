<?php

namespace Modules\About\Http\Controllers\v1\Management;

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

    public function isJson($string)
    {
        if (is_string($string)) {
            json_decode($string, true);
            return json_last_error() === JSON_ERROR_NONE;
        }
        return false;
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request)
    {
        $options = config('about.options');
        $variables = [];

        foreach ($options as $option) {
            if ($request->{$option}) {
                $value = $this->isJson($request->input($option)) ? json_encode(json_decode($request->input($option), true)) : json_encode($request->input($option));

                if ($request->file($option)) {
                    $variable = aboutRepo()->find($option);
                    if ($variable) {
                        $variable->clearMediaCollectionExcept();
                    } else {
                        $variable = About::query()->create(['name' => $option]);
                    }
                    $variable->addMedia($request->{$option})->toMediaCollection();

                    $value = json_encode($variable->getFirstMediaUrl());
                }
                array_push($variables, ['name' => $option, 'value' => $value]);
            }
        }

        About::query()->upsert($variables, ['name'], ['value']);
        ApiService::_success(trans('response.responses.200'));
    }
}
