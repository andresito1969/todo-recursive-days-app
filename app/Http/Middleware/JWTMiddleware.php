<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use JWTAuth;
use Exception;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try{
            $user = JWTAuth::parseToken()->authenticate();
            $tokenUserId = $user->id;
            $requestUserId = $request->route()->parameter('user_id');

            if($tokenUserId != $requestUserId) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } catch (Exception $e){
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                // invalid token
                return response()->json(['error' => 'Token is invalid'], 401);
            } else {
                return response()->json(['error' => 'Authorization Token not found'], 401);
            }
        }
        return $next($request);
    }
}
