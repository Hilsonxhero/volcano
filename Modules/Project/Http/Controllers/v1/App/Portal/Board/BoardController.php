<?php

namespace Modules\Project\Http\Controllers\v1\App\Portal\Board;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Project\Entities\Board;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Common\Enums\CommonStatus;
use Modules\Common\Services\ApiService;
use Modules\Project\Http\Requests\v1\App\Portal\Board\BoardRequest;
use Modules\Project\Transformers\v1\App\Portal\Board\BoardResource;

class BoardController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, $id)
    {
        $this->authorize('manage', [Board::class, $id]);
        $boards = boardRepo()->get($id);
        $boards = BoardResource::collection($boards);
        ApiService::_success($boards);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(BoardRequest $request, $project)
    {
        $user = auth()->user();
        $data = array(
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'project_id' => $request->input('project_id'),
            'user_id' => $user->id,
            'status' => CommonStatus::ACTIVE->value,
        );
        $board = boardRepo()->store($data);
        $data = [
            'email' => $user->email,
            'inviter_id' => $user->id,
            'board_id' => $board->id,
            'token' =>  Hash::make($user->email),
            'role' => 'owner',
            'status' => 'confirmed',
            'user_id' => $user->id
        ];
        $member =  boardMemberRepo()->create($data);
        ApiService::_success(trans('response.responses.200'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($project, $id)
    {
        $board = boardRepo()->show($id, "short_link");
        $this->authorize('show', [Board::class, $board]);
        $resource = new BoardResource($board);
        ApiService::_success($resource);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(BoardRequest $request, $project, $id)
    {
        $board = boardRepo()->find($id, "short_link");
        $data = array(
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            // 'status' => $request->input('status')
        );
        $board = boardRepo()->update($data, $board->id);
        ApiService::_success(new BoardResource($board));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($project, $id)
    {
        $board = boardRepo()->delete($id);
        ApiService::_success(trans('response.responses.200'));
    }
}
