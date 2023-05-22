<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\v1\App\Auth\GithubAuthController;
use Modules\Auth\Http\Controllers\v1\App\Auth\GoogleAuthController;
use Modules\Auth\Http\Controllers\v1\App\Auth\Otp\OtpAuthController;

Route::prefix('v1/application')->group(function () {

    Route::prefix('auth')->group(function () {

        Route::get("github/redirect", [GithubAuthController::class, 'redirect']);
        Route::get("github/callback", [GithubAuthController::class, 'callback']);

        Route::get("google/redirect", [GoogleAuthController::class, 'redirect']);
        Route::get("google/callback", [GoogleAuthController::class, 'callback']);

        Route::prefix('otp')->group(function () {
            Route::get("init", [OtpAuthController::class, 'init']);
            Route::post("authenticate", [OtpAuthController::class, 'authenticate']);
            Route::post("login", [OtpAuthController::class, 'login']);
        });

        Route::post("logout", [OtpAuthController::class, 'logout'])->middleware(['auth:api']);
    });
});
