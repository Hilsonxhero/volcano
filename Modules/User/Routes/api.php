<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\v1\App\Profile\UpdateProfileController;
use Modules\User\Http\Controllers\v1\App\ProjectController;
use Modules\User\Http\Controllers\v1\App\UserController;

Route::prefix('v1/application')->group(function () {
    Route::prefix('profile')->middleware(['auth:api'])->group(function () {

        Route::prefix('projects')->group(function () {
            Route::get("/", [ProjectController::class, 'index']);
            Route::post("setup", [ProjectController::class, 'setup']);
        });

        Route::prefix('update')->group(
            function () {
                Route::post('username', [UpdateProfileController::class, 'username']);
                Route::post('email', [UpdateProfileController::class, 'email']);
                Route::post('password', [UpdateProfileController::class, 'password']);
                Route::post('mobile/request', [UpdateProfileController::class, 'mobileRequest']);
                Route::post('mobile/verify', [UpdateProfileController::class, 'mobileVerify']);
            }
        );
    });

    Route::prefix('user')->group(function () {
        Route::get("init", [UserController::class, 'init']);
    });
});
