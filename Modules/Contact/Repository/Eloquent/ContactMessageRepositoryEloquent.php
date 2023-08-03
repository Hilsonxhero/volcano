<?php

namespace Modules\Contact\Repository\Eloquent;

use Modules\Article\Enums\ArticleStatus;
use Modules\Contact\Entities\ContactMessage;
use Modules\Contact\Repository\Contracts\ContactMessageRepository;

class ContactMessageRepositoryEloquent implements ContactMessageRepository
{
    public function all()
    {
        $query = ContactMessage::query()->orderBy('created_at', 'desc');
        $query->when(request()->has('q'), function ($query) {
            $searchTerm = "%" . request()->q . "%";
            $query->where(function ($query) use ($searchTerm) {
                $query->where('email', 'LIKE', $searchTerm)
                    ->orWhere('name', 'LIKE', $searchTerm);
            });
        });
        return $query->paginate();
    }

    public function takeActiveArticles()
    {
        $articles = ContactMessage::query()->orderByDesc('created_at')->where('status', ArticleStatus::ENABLE->value)->take(4)->get();
        return $articles;
    }

    public function get()
    {
        return ContactMessage::orderBy('created_at', 'desc')
            ->where('status', ArticleStatus::ENABLE->value)
            ->with(['category'])
            ->paginate(20);
    }

    public function create($data)
    {
        $article =  ContactMessage::query()->create($data);
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
            $article = ContactMessage::query()->where('id', $id)->firstOrFail();
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
