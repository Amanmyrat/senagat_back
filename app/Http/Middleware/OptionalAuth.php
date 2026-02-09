<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OptionalAuth
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->bearerToken()) {
            auth()->shouldUse('sanctum');

            $user = auth('sanctum')->user();

            if ($user) {
                auth()->setUser($user);
            }
        }

        return $next($request);
    }
}
