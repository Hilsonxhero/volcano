<?php

use Illuminate\Support\Facades\Route;


Route::prefix('v1/application')->group(function () {
});

Route::prefix('v1/management')->middleware(['auth.panel', 'auth:api'])->group(function () {
    Route::get("about/variables", [\Modules\About\Http\Controllers\v1\Management\AboutController::class, 'show']);
    Route::post("about/variables", [\Modules\About\Http\Controllers\v1\Management\AboutController::class, 'update']);
});
