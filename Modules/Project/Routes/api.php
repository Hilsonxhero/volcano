<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1/application')->group(function () {

    Route::prefix('portal')->middleware(['auth:api'])->group(function () {
        Route::prefix('projects')->group(function () {
            Route::get("/", [\Modules\Project\Http\Controllers\v1\App\Portal\ProjectController::class, 'index']);
            Route::get("{id}/show", [\Modules\Project\Http\Controllers\v1\App\Portal\ProjectController::class, 'show']);
            Route::apiResource("{id}/pages", \Modules\Project\Http\Controllers\v1\App\Portal\ProjectPageController::class);
            Route::apiResource("{id}/users", \Modules\Project\Http\Controllers\v1\App\Portal\ProjectUserController::class);
            Route::post("invite/membership", [\Modules\Project\Http\Controllers\v1\App\ProjectInviteController::class, 'store']);
            Route::post("invite/membership/confirmation", [\Modules\Project\Http\Controllers\v1\App\ProjectInviteController::class, 'confirmation']);
            Route::post("invite/membership/decline", [\Modules\Project\Http\Controllers\v1\App\ProjectInviteController::class, 'decline']);
            Route::get("invite/show/{token}", [\Modules\Project\Http\Controllers\v1\App\ProjectInviteController::class, 'show']);
            Route::post("setup", [\Modules\Project\Http\Controllers\v1\App\Portal\ProjectController::class, 'setup']);
        });
        Route::get("dashboard", [\Modules\Project\Http\Controllers\v1\App\Portal\DashboardController::class, 'index']);
    });


    // Route::prefix('projects/{id}')->group(function () {
    //     Route::get("show", [\Modules\Project\Http\Controllers\v1\App\ProjectController::class, 'show']);
    // });
});
