<?php

namespace Modules\Article;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Article\Entities\Article;
use Illuminate\Support\Facades\Storage;


Route::prefix('v1/application')->group(function () {
    Route::get("articles", [\Modules\Article\Http\Controllers\v1\App\ArticleController::class, 'index']);
    Route::get("articles/{slug}", [\Modules\Article\Http\Controllers\v1\App\ArticleController::class, 'show']);

    Route::post('/test', function () {


        try {
            // $file = request()->file('image');
            // $fileName = $file->getClientOriginalName();

            // Storage::disk('s3')->put($fileName, file_get_contents($file));
            $article = Article::first();
            $article->addMediaFromDisk(request()->image, 's3')->toMediaCollection('main');
            return "done";
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    });
});

Route::prefix('v1/management')->middleware(['auth.panel', 'auth:api'])->group(function () {
    Route::apiResource("/articles", \Modules\Article\Http\Controllers\v1\Management\ArticleController::class);
});
