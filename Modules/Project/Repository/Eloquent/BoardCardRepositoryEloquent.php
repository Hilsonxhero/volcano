<?php

namespace Modules\Project\Repository\Eloquent;

use Modules\Project\Entities\BoardCard;
use Modules\Project\Repository\Contracts\BoardCardRepository;

class BoardCardRepositoryEloquent implements BoardCardRepository
{

    public function all($project)
    {
        $query = BoardCard::orderBy('created_at', 'desc')->where('project_id', $project);
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
        $boards = BoardCard::query()->where('board_id', $id)->orderBy('position', 'desc')->get();
        return $boards;
    }

    public function show($id)
    {
        $board = $this->find($id, 'id');
        return $board;
    }

    public function find($value, $condition = "id")
    {
        return BoardCard::query()->where($condition, $value)->first();
    }

    public function store($data)
    {
        $board = BoardCard::query()->create($data);
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
