<?php

namespace Modules\Project\Http\Controllers\v1\App\Portal\Board;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Common\Enums\CommonStatus;
use Modules\Common\Services\ApiService;
use Modules\Project\Http\Requests\v1\App\Portal\Board\BoardCardRequest;
use Modules\Project\Transformers\v1\App\Portal\Board\BoardCardResource;

class BoardCardController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, $id)
    {
        $board_cards = boardCardRepo()->get($id);
        $board_cards = BoardCardRequest::collection($board_cards);
        ApiService::_success($board_cards);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(BoardCardRequest $request, $list)
    {
        $user = auth()->user();
        $data = array(
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'board_list_id' => $list,
            'status' => CommonStatus::ACTIVE->value,
            'user_id' => $user->id
        );
        $board_card = boardCardRepo()->store($data);
        ApiService::_success(new BoardCardResource($board_card));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($project, $id)
    {
        $board_card = boardCardRepo()->show($id);
        $resource = new BoardCardRequest($board_card);
        ApiService::_success($resource);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(BoardCardRequest $request, $project, $id)
    {
        $data = array(
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        );
        $board_card = boardCardRepo()->update($data, $id);
        ApiService::_success(trans('response.responses.200'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($project, $id)
    {
        $board_card = boardCardRepo()->delete($id);
        ApiService::_success(trans('response.responses.200'));
    }
}
