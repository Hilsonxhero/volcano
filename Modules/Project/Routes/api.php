<?php

use Illuminate\Support\Facades\Route;
use Modules\Project\Http\Controllers\v1\Management\ProjectController;
use Modules\Project\Http\Controllers\v1\Management\ProjectMemberController;
use Modules\Project\Http\Controllers\v1\Management\ProjectPageController;

Route::prefix('v1/application')->group(function () {
    Route::prefix('portal')->middleware(['auth:api'])->group(function () {
        Route::prefix('projects')->group(function () {
            Route::get("/", [\Modules\Project\Http\Controllers\v1\App\Portal\ProjectController::class, 'index']);
            Route::get("{id}/show", [\Modules\Project\Http\Controllers\v1\App\Portal\ProjectController::class, 'show']);
            Route::apiResource("{id}/pages", \Modules\Project\Http\Controllers\v1\App\Portal\ProjectPageController::class);
            Route::apiResource("{id}/users", \Modules\Project\Http\Controllers\v1\App\Portal\ProjectUserController::class);
            Route::apiResource("{id}/roles", \Modules\Project\Http\Controllers\v1\App\Portal\ProjectRoleController::class);
            Route::apiResource("{id}/issues", \Modules\Project\Http\Controllers\v1\App\Portal\ProjectIssueController::class);
            Route::prefix("{id}/enumerations")->group(function () {
                Route::apiResource("time/categories", \Modules\Project\Http\Controllers\v1\App\Portal\ProjectTimeCategoryController::class);
                Route::apiResource("trackers", \Modules\Project\Http\Controllers\v1\App\Portal\ProjectTrackerController::class);
                Route::apiResource("issue/statuses", \Modules\Project\Http\Controllers\v1\App\Portal\ProjectIssueStatusController::class);
            });
            Route::get("{id}/permissions", [\Modules\Project\Http\Controllers\v1\App\Portal\ProjectPermissionController::class, 'index']);
            Route::post("invite/membership", [\Modules\Project\Http\Controllers\v1\App\ProjectInviteController::class, 'store']);
            Route::post("invite/membership/confirmation", [\Modules\Project\Http\Controllers\v1\App\ProjectInviteController::class, 'confirmation']);
            Route::post("invite/membership/decline", [\Modules\Project\Http\Controllers\v1\App\ProjectInviteController::class, 'decline']);
            Route::get("invite/show/{token}", [\Modules\Project\Http\Controllers\v1\App\ProjectInviteController::class, 'show']);
            Route::post("setup", [\Modules\Project\Http\Controllers\v1\App\Portal\ProjectController::class, 'setup']);
        });
        Route::get("dashboard", [\Modules\Project\Http\Controllers\v1\App\Portal\DashboardController::class, 'index']);
    });
    Route::prefix('software')->group(function () {
        Route::get("projects/{id}/show", [\Modules\Project\Http\Controllers\v1\App\Software\ProjectController::class, 'show']);
        Route::get("projects/{id}/pages/{page}", [\Modules\Project\Http\Controllers\v1\App\Software\ProjectPageController::class, 'show']);
    });
});

Route::prefix('v1/management')->middleware(['auth.panel', 'auth:api'])->group(function () {
    Route::apiResource("projects", ProjectController::class);
    Route::apiResource("project/{id}/pages", ProjectPageController::class);
    Route::apiResource("project/{id}/members", ProjectMemberController::class);
});
