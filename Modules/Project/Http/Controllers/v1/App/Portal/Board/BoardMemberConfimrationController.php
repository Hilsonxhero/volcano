<?php

namespace Modules\Project\Http\Controllers\v1\App\Portal\Board;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\Project\Transformers\v1\App\Portal\Board\BoardMemberResource;
use Modules\Project\Transformers\v1\App\Portal\Board\BoardMemberConfirmationResource;

class BoardMemberConfimrationController extends Controller
{



    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function show(Request $request, $id)
    {
        $member = boardMemberRepo()->find($id);
        $member = new BoardMemberConfirmationResource($member);
        ApiService::_success($member);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request, $id)
    {
        $user = auth()->user();
        if ($request->confirm) {
            $status = "confirmed";
        } else {
            $status = "rejected";
        }
        $member = boardMemberRepo()->find($request->token, "token");
        $member->update([
            'status' => $status,
            'user_id' => $user->id
        ]);
        ApiService::_success(new BoardMemberResource($member));
    }
}
