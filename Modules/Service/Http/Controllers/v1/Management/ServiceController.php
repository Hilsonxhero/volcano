<?php

namespace Modules\Service\Http\Controllers\v1\Management;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\Service\Http\Requests\Management\ServiceRequest;
use Modules\Service\Transformers\Management\ServiceResource;

class ServiceController extends Controller
{


    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $services = serviceRepo()->all();
        $services_collection = ServiceResource::collection($services);
        ApiService::_success(
            array(
                'services' => $services_collection,
                'pager' => array(
                    'pages' => $services_collection->lastPage(),
                    'total' => $services_collection->total(),
                    'current_page' => $services_collection->currentPage(),
                    'per_page' => $services_collection->perPage(),
                )
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(ServiceRequest $request)
    {
        $data = array(
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        );
        $service = serviceRepo()->create($data);
        base64($request->media) ? $service->addMediaFromBase64($request->media)->toMediaCollection('main')
            : $service->addMedia($request->media)->toMediaCollection('main');
        ApiService::_success(trans('response.responses.200'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $service = serviceRepo()->show($id);
        return new ServiceResource($service);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(ServiceRequest $request, $id)
    {
        $data = array(
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        );
        $service = serviceRepo()->update($id, $data);
        if ($request->media) {
            $service->clearMediaCollectionExcept();
            base64($request->media) ? $service->addMediaFromBase64($request->media)->toMediaCollection()
                : $service->addMedia($request->media)->toMediaCollection();
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
        $service = serviceRepo()->delete($id);
        ApiService::_success(trans('response.responses.200'));
    }
}
