<?php

namespace Modules\Feature\Http\Controllers\v1\Management;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\Feature\Http\Requests\Management\FeatureRequest;
use Modules\Feature\Transformers\Management\FeatureResource;

class FeatureController extends Controller
{


    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $features = featureRepo()->all();
        $features_collection = FeatureResource::collection($features);
        ApiService::_success(
            array(
                'features' => $features_collection,
                'pager' => array(
                    'pages' => $features_collection->lastPage(),
                    'total' => $features_collection->total(),
                    'current_page' => $features_collection->currentPage(),
                    'per_page' => $features_collection->perPage(),
                )
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(FeatureRequest $request)
    {

        $data = array(
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        );
        $feaure = featureRepo()->create($data);
        if ($request->file('cover')) {
            $feaure->addMedia($request->cover)->toMediaCollection('cover');
        }
        if ($request->file('icon')) {
            $feaure->addMedia($request->icon)->toMediaCollection('icon');
        }
        ApiService::_success(trans('response.responses.200'));
    }

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

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(FeatureRequest $request, $id)
    {
        $data = array(
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        );
        $feaure = featureRepo()->update($id, $data);
        if ($request->file('cover')) {
            $feaure->clearMediaCollection('cover');
            $feaure->addMedia($request->cover)->toMediaCollection('cover');
        }
        if ($request->file('icon')) {
            $feaure->clearMediaCollection('icon');
            $feaure->addMedia($request->icon)->toMediaCollection('icon');
        }
        ApiService::_success(trans('response.responses.200'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $feaure = featureRepo()->delete($id);
        if ($feaure->getFirstMediaUrl('cover')) {
            $feaure->clearMediaCollection('cover');
        }
        if ($feaure->getFirstMediaUrl('icon')) {
            $feaure->clearMediaCollection('icon');
        }
        ApiService::_success(trans('response.responses.200'));
    }
}
