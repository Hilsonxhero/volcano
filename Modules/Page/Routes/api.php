<?php

Route::prefix('v1/management')->middleware(['auth.panel', 'auth:api'])->group(function () {
    Route::apiResource('pages', \Modules\Page\Http\Controllers\v1\Management\PageController::class);
});
