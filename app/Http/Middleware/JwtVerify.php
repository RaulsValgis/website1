<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use stdClass;

class JwtVerify
{
    public function handle($request, Closure $next)
    {
        $apiToken = $request->bearerToken();
        
        if (!$apiToken) {
            return response('Unauthorized', 401);
        }

        $allowedAlgorithms = new stdClass();
        $allowedAlgorithms->alg = 'HS256';

        $key = config('jwt.keys.shared_secret_key');

        
        try {
            

            $decoded = JWT::decode($apiToken, $key, $allowedAlgorithms);
        } catch (\Exception $e) {
            return response('Unauthorized', 401);
        }

        return $next($request);
    }
}
