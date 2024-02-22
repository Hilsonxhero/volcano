<?php

namespace Modules\Project\Http\Controllers\v1\App\Portal\Board;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Common\Enums\CommonStatus;
use Modules\Common\Services\ApiService;
use Modules\Project\Entities\BoardCard;
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
        $last_card = BoardCard::where('board_list_id', $list)->latest()->first();
        $last_card_position = !is_null($last_card) ? $last_card->position + 1 : 1;
        $data = array(
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'board_list_id' => $list,
            'status' => CommonStatus::ACTIVE->value,
            'user_id' => $user->id,
            'position' => $last_card_position
        );
        $board_card = boardCardRepo()->store($data);
        if ($request->attachments) {
            foreach ($request->attachments as $key => $attachment) {
                $board_card->addMedia($attachment)->toMediaCollection();
            }
        }
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

    public function position(Request $request)
    {
        $card = boardCardRepo()->find($request->id);
        $board_list = boardListRepo()->find($request->board_list_id);
        $cardId = $request->id;
        $newIndex = $request->newIndex;
        $boardListId = $request->board_list_id;
        $card = BoardCard::findOrFail($cardId);
        $data = [
            'board_list_id' => $request->board_list_id,
            'position' => $newIndex
        ];
        $board_card = boardCardRepo()->update($data, $request->id);
        $cardsInList = BoardCard::where('board_list_id', $boardListId)->orderBy('position', 'asc')->orderBy('updated_at', 'desc')->get();
        foreach ($cardsInList as $index => $otherCard) {
            $otherCard->position = $index;
            $otherCard->save();
        }
        ApiService::_success(new BoardCardResource($card));
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

        if ($request->attachments) {
            foreach ($request->attachments as $key => $attachment) {
                $board_card->addMedia($attachment)->toMediaCollection();
            }
        }
        ApiService::_success(new BoardCardResource($board_card));
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
