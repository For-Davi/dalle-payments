<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Projects;

class VerifyPaymentData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $projectName = $request->input('name');
        $apiKey = $request->input('api_key');

        $project = Projects::where('name', $projectName)->where('api_key', $apiKey)->where('active', 1)->first();

        if(!$project){
            return response()->json([
                'message' => 'Os dados enviados são inválidos'
            ], 401);
        }

        return $next($request);
    }
}
