<?php

namespace Modules\Project\Http\Controllers\v1\App\Portal\Board;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Modules\Common\Services\ApiService;
use Modules\Sms\Services\SendSmsService;
use Modules\Project\Emails\SendJoinBoardMail;
use Modules\Project\Http\Requests\v1\App\Portal\Board\BoardMemberRequest;
use Modules\Project\Transformers\v1\App\Portal\Board\BoardMemberResource;

class BoardMemberController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, $board)
    {
        $board = boardRepo()->find($board);
        $board_members = BoardMemberResource::collection($board->members);
        ApiService::_success($board_members);
    }


    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function show(Request $request, $board, $id)
    {
        $member = boardRepo()->find($id);
        $member = new BoardMemberResource($member);
        ApiService::_success($member);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(BoardMemberRequest $request, $id)
    {
        $user = auth()->user();
        $invited_user = userRepo()->find($request->email, "email");
        $invited_board = boardRepo()->find($id, "short_link");
        $data = [
            'email' => $request->email,
            'inviter_id' => $user->id,
            'board_id' => $invited_board->id,
            'token' =>  Str::random(5),
            'role' => 'member',
            'status' => 'pending',
            'user_id' => !is_null($invited_user) ? $invited_user->id : null
        ];

        $member =  boardMemberRepo()->create($data);
        $mail_data  = [
            'name' => $user->username,
            'board' => $invited_board,
            'url' => front_path("portal/projects/board/confirmation", ['token' => $member->token, 'id' => $member->id])
        ];

        Mail::to($member->email)->send(new SendJoinBoardMail($mail_data));

        // SendSmsService::send(
        //     $member->email,
        //     "project_invite_board_user",
        //     [
        //         $user->username,
        //         $mail_data['board']['title'],
        //         $mail_data['url']
        //     ]
        // );

        $board_members = BoardMemberResource::collection($member->board->members);
        ApiService::_success($board_members);
        // ApiService::_success(new BoardMemberResource($member));
    }



    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($board, $id)
    {
        $member = boardMemberRepo()->find($id);
        boardMemberRepo()->delete($id);
        // ApiService::_success(trans('response.responses.200'));
        $board_members = BoardMemberResource::collection($member->board->members);
        ApiService::_success($board_members);
    }
}
