<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class ExecutionTimeMiddleware
{
    public function handle($request, Closure $next)
    {
        // Start timer
        $startTime = microtime(true);

        // Process the request
        $response = $next($request);

        // Calculate execution time
        $executionTime = microtime(true) - $startTime;

        // Store execution time in the application container
        App::instance('executionTime', $executionTime);

        return $response;
    }
}