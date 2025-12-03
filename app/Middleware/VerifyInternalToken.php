<?php

namespace App\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyInternalToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('access-token');

        if (! $token || $token !== config('app.access_token')) {
            return response()->json(['message' => 'Token inválido'], 403);
        }

        return $next($request);
    }
}
