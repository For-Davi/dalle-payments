<?php

namespace App\Modules\Asaas\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyAsaasToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('asaas-access-token');

        if (! $token || $token !== config('app.asaas_access_token')) {
            return response()->json(['message' => 'Token inválido'], 403);
        }

        return $next($request);
    }
}
