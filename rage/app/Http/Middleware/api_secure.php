<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class api_secure
{
    public function handle($request, Closure $next)
    {
        if($request->getClientIp() != $_SERVER['SERVER_ADDR']) return response()->json('Invalid Request');
        return $next($request);
    }
}
