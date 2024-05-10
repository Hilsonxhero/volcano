<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Media\Http\Controllers\v1\App\EditorUploadeController;
use Modules\Media\Http\Controllers\v1\App\MediaController;

Route::prefix('v1/application')->group(function () {
    // Route::delete("media/delete/{id}", [MediaController::class, 'destroy']);
    Route::post('upload/editor', EditorUploadeController::class)->middleware(['auth:api']);
    Route::get("media/download/stream/{id}", [MediaController::class, 'stream']);
    Route::get("media/download/{id}", [MediaController::class, 'download'])->name("media.download.store");
});
