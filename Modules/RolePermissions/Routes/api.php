<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\RolePermissions\Http\Controllers\v1\App\Portal\RoleController;

Route::prefix('v1/application')->group(function () {
    Route::prefix('portal')->middleware(['auth:api'])->group(function () {
        Route::get("roles", [RoleController::class, 'index']);
    });
});
