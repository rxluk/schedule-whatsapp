<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('X-API-KEY') ?? $request->query('api_key');
        
        if (!$apiKey || $apiKey !== config('app.api_key')) {
            return response()->json([
                'error' => 'API Key inválida ou não fornecida',
                'status' => 401
            ], 401);
        }
        
        return $next($request);
    }
}
