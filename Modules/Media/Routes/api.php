<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Media\Http\Controllers\v1\App\EditorUploadeController;


Route::prefix('v1/application')->middleware(['auth:api'])->group(function () {
    // Route::delete("media/delete/{id}", [MediaController::class, 'destroy']);
    Route::post('upload/editor', EditorUploadeController::class);
});
