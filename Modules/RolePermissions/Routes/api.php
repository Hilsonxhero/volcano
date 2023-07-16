<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1/management')->middleware(['auth.panel', 'auth:api'])->group(function () {
    Route::apiResource("roles", Modules\RolePermissions\Http\Controllers\v1\Management\RoleController::class);
    Route::get("role/select", [Modules\RolePermissions\Http\Controllers\v1\Management\RoleController::class, 'select']);
    Route::apiResource("permissions", Modules\RolePermissions\Http\Controllers\v1\Management\PermissionController::class);
    Route::get("permission/select", [Modules\RolePermissions\Http\Controllers\v1\Management\PermissionController::class, 'select']);
    Route::get("permission/select/parent", [Modules\RolePermissions\Http\Controllers\v1\Management\PermissionController::class, 'getParents']);
});

Route::prefix('v1/application')->group(function () {
    Route::prefix('portal')->middleware(['auth:api'])->group(function () {
        Route::get("roles", [\Modules\RolePermissions\Http\Controllers\v1\App\Portal\RoleController::class, 'index']);
    });
});
