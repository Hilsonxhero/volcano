<?php

namespace Modules\Project\Repository\Eloquent;

use Modules\Project\Entities\BoardMember;
use Modules\Project\Repository\Contracts\BoardMemberRepository;

class BoardMemberRepositoryEloquent implements BoardMemberRepository
{



    public function get($id)
    {
        $boards = BoardMember::query()->where('board_id', $id)->orderBy('created_at', 'desc')->get();
        return $boards;
    }

    public function show($id)
    {
        $board = $this->find($id, 'id');
        return $board;
    }

    public function find($value, $condition = "id")
    {
        return BoardMember::query()->where($condition, $value)->first();
    }

    public function create($data)
    {
        $board = BoardMember::query()->create($data);
        return $board;
    }

    public function update($data, $id)
    {
        $board = $this->find($id, 'id');
        $board->update($data);
        return $board;
    }

    public function delete($id)
    {
        $board = $this->find($id, 'id');
        $board->delete();
        return true;
    }
}
