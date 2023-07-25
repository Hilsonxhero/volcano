<?php

use Illuminate\Http\Request;
use Modules\Web\Http\Controllers\v1\Web\WebController;

Route::prefix('v1/application')->group(function () {
    Route::get("init", [WebController::class, 'init']);
});
