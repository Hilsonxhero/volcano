<?php

namespace Modules\Media\Http\Controllers\v1\App;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\URL;
use Modules\Common\Services\ApiService;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    public function stream($id)
    {
        $url = URL::temporarySignedRoute('media.download.store', now()->addHours(1), ['id' => $id]);
        ApiService::_success($url);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function download($id)
    {
        $mediaItem = Media::query()->where('id', $id)->first();
        return response()->download($mediaItem->getPath(), $mediaItem->file_name);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        Media::findByUuid($id)->delete();
        ApiService::_success(trans('response.responses.200'));
    }
}
