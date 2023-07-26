<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Feature\Http\Controllers\v1\Management\FeatureController;

Route::prefix('v1/management')->middleware(['auth.panel', 'auth:api'])->group(function () {
    Route::apiResource('features', FeatureController::class);
});
