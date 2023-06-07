<?php

namespace App\Http\Middleware;

use Closure;

class VerifyAccessKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $key = $request->headers->get('api-key');
        
        return $key == env('API_KEY')
            ? $next($request)
            : response()->json(['error' => 'unauthorized'], 401);
    }
}
