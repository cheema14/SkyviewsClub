<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use \Laravel\Sanctum\PersonalAccessToken;

class CheckMultipleLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $auth_token = $request->header('Authorization');
        
        // if(preg_match('/Bearer\s+(.*)$/i', $auth_token, $matches)) {
        //     $auth_token = $matches[1];
        // }

        if (preg_match('/\|(.*?)$/', $auth_token, $matches)) {
            $auth_token = $matches[1];
        }
       
        
        $token = PersonalAccessToken::where('token', hash('sha256', $auth_token))
        ->where('is_active', 1)
        ->first();
       
        
        if (!$token) {
            return response()->json([
                'status' => false,
                'message' => 'Session expired. Please login again.',
                'code' => 402,
            ]);
        }
        

        $userTokens = auth()->user()->tokens()->where('is_active', 1)->get();
        
        if ($userTokens->count() > 1) {
            
            return response()->json([
                'status' => false,
                'message' => 'Session expired. Please login again.',
                'code' => 402,
            ]);
        }

        return $next($request);
    }
}
