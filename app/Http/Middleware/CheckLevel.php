<?php

namespace App\Http\Middleware;

use App\Helpers\ApiResponse;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, int $level): Response
    {
        $user = Auth::user();

        if (!$user || $user->level != $level) {
            return ApiResponse::sendErrors("Unauthorized", code:403);
        }

        return $next($request);
    }
}
