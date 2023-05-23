<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\v1\App\ProjectController;

Route::prefix('v1/application')->group(function () {
    Route::prefix('profile')->middleware(['auth:api'])->group(function () {
        Route::prefix('projects')->group(function () {
            Route::get("/", [ProjectController::class, 'index']);
            Route::post("setup", [ProjectController::class, 'setup']);
        });
    });
});
