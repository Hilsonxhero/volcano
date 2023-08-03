<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Contact\Http\Controllers\v1\Web\ContactMessageController;

Route::prefix('v1/application')->group(function () {
    Route::post("contact/messages", [ContactMessageController::class, 'store']);
});

Route::prefix('v1/management')->middleware(['auth.panel', 'auth:api'])->group(function () {
    Route::apiResource("/contact/messages", \Modules\Contact\Http\Controllers\v1\Management\ContactMessageController::class);
});
