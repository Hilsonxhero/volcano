<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Project\Http\Controllers\v1\App\ProjectController;
use Modules\Project\Http\Controllers\v1\App\ProjectInviteController;
use Modules\Project\Http\Controllers\v1\App\User\ProjectPageController;

Route::prefix('v1/application')->group(function () {

    Route::prefix('software/projects/{id}')->middleware(['auth:api'])->group(function () {
        Route::apiResource("pages", ProjectPageController::class);
        Route::post("invite/membership", [ProjectInviteController::class, 'store']);
        Route::post("invite/membership/confirmation", [ProjectInviteController::class, 'confirmation']);
    });

    Route::prefix('profile')->middleware(['auth:api'])->group(function () {
        Route::prefix('projects')->group(function () {
            Route::get("/", [\Modules\Project\Http\Controllers\v1\App\User\ProjectController::class, 'index']);
            Route::post("setup", [\Modules\Project\Http\Controllers\v1\App\User\ProjectController::class, 'setup']);
        });
    });

    Route::prefix('projects/{id}')->group(function () {
        Route::get("show", [ProjectController::class, 'show']);
    });
});
