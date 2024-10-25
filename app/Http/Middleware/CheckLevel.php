<?php

namespace App\Http\Middleware;

use App\Helpers\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLevel
{
    public function handle(Request $request, Closure $next, $level): Response
    {
        $user = $request->attributes->get('user');

        if (!$user) {
            return ApiResponse::sendErrors("Unauthorized: Please log in.", code: 401);
        }

        if ($user->level != $level) {
            return ApiResponse::sendErrors("Unauthorized: Access level $level is required.", code: 403);
        }

        return $next($request);
    }
}
