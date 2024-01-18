<?php

namespace Modules\Project\Http\Controllers\v1\App\Portal\Board;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Common\Enums\CommonStatus;
use Modules\Common\Services\ApiService;
use Modules\Project\Http\Requests\v1\App\Portal\Board\BoardListRequest;
use Modules\Project\Transformers\v1\App\Portal\Board\BoardListResource;

class BoardListController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, $id)
    {
        $board_lists = boardListRepo()->get($id);
        $board_lists = BoardListResource::collection($board_lists);
        ApiService::_success($board_lists);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(BoardListRequest $request, $project)
    {
        $user = auth()->user();
        $data = array(
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'board_id' => $request->input('board_id'),
            'status' => CommonStatus::ACTIVE->value,
        );
        $board_list = boardListRepo()->store($data);
        ApiService::_success(trans('response.responses.200'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($project, $id)
    {
        $board_list = boardListRepo()->show($id);
        $resource = new BoardListResource($board_list);
        ApiService::_success($resource);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(BoardListRequest $request, $project, $id)
    {
        $data = array(
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        );
        $board_list = boardListRepo()->update($data, $id);
        ApiService::_success(trans('response.responses.200'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($project, $id)
    {
        $board_list = boardListRepo()->delete($id);
        ApiService::_success(trans('response.responses.200'));
    }
}
