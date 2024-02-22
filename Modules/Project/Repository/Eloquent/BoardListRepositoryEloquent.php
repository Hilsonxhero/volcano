<?php

namespace Modules\Project\Repository\Eloquent;

use Modules\Project\Entities\Board;
use Modules\Project\Entities\BoardList;
use Modules\Project\Repository\Contracts\BoardListRepository;

class BoardListRepositoryEloquent implements BoardListRepository
{

    public function all($project)
    {
        $query = BoardList::orderBy('created_at', 'desc')->where('project_id', $project);
        $query->when(request()->has('q'), function ($query) {
            $searchTerm = "%" . request()->q . "%";
            $query->where(function ($query) use ($searchTerm) {
                $query->where('title', 'LIKE', $searchTerm);
            });
        });

        return $query->paginate();
    }

    public function get($id)
    {
        $boards = BoardList::query()->where('board_id', $id)->get();
        return $boards;
    }

    public function show($id)
    {
        $board = $this->find($id, 'id');
        return $board;
    }

    public function find($value, $condition = "id")
    {
        return BoardList::query()->where($condition, $value)->first();
    }

    public function store($data)
    {
        $board = BoardList::query()->create($data);
        return $board;
    }

    public function update($data, $id)
    {
        $list = $this->find($id, 'id');
        $list->update($data);
        return $list;
    }

    public function delete($id)
    {
        $board = $this->find($id, 'id');
        $board->delete();
        return true;
    }
}
