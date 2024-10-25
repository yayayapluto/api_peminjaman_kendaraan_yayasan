<?php

namespace App\Http\Middleware;

use App\Helpers\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Sanctum\PersonalAccessToken;

class CheckToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (!$token) {
            return ApiResponse::sendErrors("Cannot find bearer token", code: 400);
        }

        $tokenRecord = PersonalAccessToken::findToken($token);

        if (!$tokenRecord) {
            return ApiResponse::sendErrors("Invalid token", code: 401);
        }

        $user = $tokenRecord->tokenable;

        if (!$user->is_enable) {
            return ApiResponse::sendErrors("User account is inactive", code: 403);
        }

        $request->attributes->set('user', $user);

        return $next($request);
    }
}
