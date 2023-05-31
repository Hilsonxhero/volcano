<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Project\Http\Controllers\v1\App\ProjectController;
use Modules\Project\Http\Controllers\v1\App\ProjectInviteController;
use Modules\Project\Http\Controllers\v1\App\User\ProjectPageController;

Route::prefix('v1/application')->group(function () {

    Route::prefix('projects')->middleware(['auth:api'])->group(function () {
        Route::post("invite/membership", [ProjectInviteController::class, 'store']);
        Route::post("invite/membership/confirmation", [ProjectInviteController::class, 'confirmation']);
    });

    Route::prefix('profile')->middleware(['auth:api'])->group(function () {
        Route::apiResource("projects/{id}/pages", ProjectPageController::class);
    });
});
