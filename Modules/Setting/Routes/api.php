<?php

Route::prefix('v1/management')->middleware(['auth.panel', 'auth:api'])->group(function () {
    Route::prefix('setting')->group(
        function () {
            Route::get("/variables", [\Modules\Setting\Http\Controllers\v1\Management\SettingController::class, 'index']);
            Route::post("/variables", [\Modules\Setting\Http\Controllers\v1\Management\SettingController::class, 'update']);
        }
    );
});
