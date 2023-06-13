<?php

namespace Modules\User\Http\Middleware;

use Closure;

use Illuminate\Http\Request;
use Modules\Common\Services\ApiService;

class AdminAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->isSuperUser()) {
            return $next($request);
        }

        return ApiService::_response("دسترسی غیرمجاز کاربر", 401);
    }
}
