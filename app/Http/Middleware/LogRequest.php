<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class LogRequest
{
    public function handle($request, Closure $next)
    {
        Log::info('Request received', [
            'url' => $request->url(),
            'method' => $request->method(),
            'ip' => $request->ip(),
        ]);
        return $next($request);
    }
}  