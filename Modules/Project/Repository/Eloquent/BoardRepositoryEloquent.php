<?php

namespace Modules\Project\Repository\Eloquent;

use Modules\Project\Entities\Board;
use Modules\Project\Repository\Contracts\BoardRepository;

class BoardRepositoryEloquent implements BoardRepository
{

    public function all($project)
    {
        $query = Board::orderBy('created_at', 'desc')->where('project_id', $project);
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
        $boards = Board::query()->where('project_id', $id)->orderByDesc('created_at')->get();
        return $boards;
    }

    public function show($id, $condition = "id")
    {
        $board = $this->find($id, $condition);
        return $board;
    }

    public function find($value, $condition = "id")
    {
        return Board::query()->where($condition, $value)->first();
    }

    public function store($data)
    {
        $board = Board::query()->create($data);
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
