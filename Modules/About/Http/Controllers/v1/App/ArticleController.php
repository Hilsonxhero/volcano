<?php

namespace Modules\Article\Http\Controllers\v1\App;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\Article\Http\Requests\ArticleRequest;
use Modules\Article\Transformers\ArticleResource;

class ArticleController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $articles = articleRepo()->get();
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
     * Display a listing of the resource.
     * @return Response
     */
    public function show(Request $request, $id)
    {
        $article = articleRepo()->show($id);

        $article_collection = new ArticleResource($article);

        $related_articles =  ArticleResource::collection(articleRepo()->related($article));


        ApiService::_success(
            array(
                'article' => $article_collection,
                'related_articles' => $related_articles,
            )
        );
    }
}
