<?php

namespace Modules\Article\Http\Controllers\v1\Management;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\Article\Http\Requests\ArticleRequest;
use Modules\Article\Transformers\ArticleResource;
use Modules\Article\Repository\ArticleRepositoryInterface;

class ArticleController extends Controller
{
    private $articleRepo;

    public function __construct(ArticleRepositoryInterface $articleRepo)
    {
        $this->articleRepo = $articleRepo;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $articles = $this->articleRepo->all();
        $articles_collection = ArticleResource::collection($articles);
        ApiService::_success(
            array(
                'articles' => $articles_collection,
                'pager' => array(
                    'pages' => $articles_collection->lastPage(),
                    'total' => $articles_collection->total(),
                    'current_page' => $articles_collection->currentPage(),
                    'per_page' => $articles_collection->perPage(),
                )
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(ArticleRequest $request)
    {
        $data = array(
            'title' => $request->title,
            'content' => $request->content,
            'description' => $request->description,
            'status' => $request->status,
            'category_id' => $request->category_id,
            'published_at' => now(),
        );
        $article = $this->articleRepo->create($data);
        base64($request->image) ? $article->addMediaFromBase64($request->image)->toMediaCollection('main')
            : $article->addMedia($request->image)->toMediaCollection('main');

        ApiService::_success(trans('response.responses.200'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $article = $this->articleRepo->show($id);
        return new ArticleResource($article);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(ArticleRequest $request, $id)
    {
        $article = $this->articleRepo->update($id, $request);
        ApiService::_success(trans('response.responses.200'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $article = $this->articleRepo->delete($id);
        ApiService::_success(trans('response.responses.200'));
    }
}
