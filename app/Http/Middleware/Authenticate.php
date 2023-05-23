<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Modules\Common\Services\ApiService;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request)
    {
        if (!$request->expectsJson()) {
            ApiService::_response("دسترسی غیرمجاز", 401);
        }
    }
}
