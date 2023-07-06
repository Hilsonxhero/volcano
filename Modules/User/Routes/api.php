<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\v1\App\Profile\UpdateProfileController;

Route::prefix('v1/management')->middleware(['auth.panel', 'auth:api'])->group(function () {
    Route::apiResource("users", \Modules\User\Http\Controllers\v1\Management\UserController::class);
    Route::get("user/select", [\Modules\User\Http\Controllers\v1\Management\UserController::class, 'select']);
});

Route::prefix('v1/application')->group(function () {
    Route::prefix('profile')->middleware(['auth:api'])->group(function () {
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
        Route::get("init", [\Modules\User\Http\Controllers\v1\App\UserController::class, 'init']);
    });
});
