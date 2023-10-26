<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $apiToken = $request->bearerToken();

        if ($apiToken !== '7sin0CMV31dvW7zWP03lOnRWPFOjSMM2plvfdtvZb2oA9URr8Vuuym9UD3msdkb7') {
            return response('Unauthorized', 401);
        }

        return $next($request);
    }
}
