<?php

namespace Modules\Article\Repository\Eloquent;

use Modules\Article\Entities\Article;
use Modules\Article\Enums\ArticleStatus;
use Modules\Article\Repository\Contracts\ArticleRepository;

class ArticleRepositoryEloquent implements ArticleRepository
{
    public function all()
    {
        $query = Article::query()->orderBy('created_at', 'desc')->with(['category']);
        $query->when(request()->has('q'), function ($query) {
            $searchTerm = "%" . request()->q . "%";
            $query->where(function ($query) use ($searchTerm) {
                $query->where('title', 'LIKE', $searchTerm)
                    ->orWhere('content', 'LIKE', $searchTerm);
            });
        });
        return $query->paginate();
    }

    public function takeActiveArticles()
    {
        $articles = Article::query()->orderByDesc('created_at')->where('status', ArticleStatus::ENABLE->value)->take(4)->get();
        return $articles;
    }

    public function get()
    {
        return Article::orderBy('created_at', 'desc')
            ->where('status', ArticleStatus::ENABLE->value)
            ->with(['category'])
            ->paginate(20);
    }

    public function related($article)
    {
        return Article::orderBy('created_at', 'desc')
            ->where('status', ArticleStatus::ENABLE->value)
            ->where('category_id', $article->category_id)
            ->whereNot('id', $article->id)
            ->with(['category'])
            ->take(6)
            ->get();
    }

    public function take()
    {
        return Article::with('category')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();
    }

    public function allActive()
    {
        return Article::orderBy('created_at', 'desc')
            ->where('status', ArticleStatus::ENABLE->value)
            ->with('parent')
            ->paginate();
    }


    public function create($data)
    {
        $article =  Article::query()->create($data);
        return $article;
    }
    public function update($id, $data)
    {
        $article = $this->find($id);
        $article->update($data);
        return $article;
    }
    public function show($id)
    {
        $article = $this->find($id);
        return $article;
    }

    public function find($id)
    {
        try {
            $article = Article::query()->where('id', $id)->firstOrFail();
            return $article;
        } catch (ModelNotFoundException $e) {
            return  ApiService::_response(trans('response.responses.404'), 404);
        }
    }
    public function delete($id)
    {
        $article = $this->find($id);
        $article->delete();
    }
}
