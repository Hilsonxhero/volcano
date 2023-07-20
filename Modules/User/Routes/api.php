<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\v1\App\Profile\UpdateEmailController;
use Modules\User\Http\Controllers\v1\App\Profile\UpdatePhoneController;
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
                Route::post('avatar', [UpdateProfileController::class, 'avatar']);
                Route::post('email/request', [UpdateEmailController::class, 'request']);
                Route::post('email/confirm', [UpdateEmailController::class, 'confirm']);
                Route::post('mobile/request', [UpdatePhoneController::class, 'request']);
                Route::post('mobile/confirm', [UpdatePhoneController::class, 'confirm']);
            }
        );
    });

    Route::prefix('user')->group(function () {
        Route::get("init", [\Modules\User\Http\Controllers\v1\App\UserController::class, 'init']);
    });
});
