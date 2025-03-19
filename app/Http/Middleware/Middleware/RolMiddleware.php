<?php

namespace App\Http\Middleware\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RolMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Check if the user is logged in
        if (!$user) {
            return response()->json(['error' => 'Unauthorized access. Please log in.'], 401);
        }

        // Check if the user has at least one of the required roles
        if (!$user->hasAnyRole($roles)) {
            return response()->json([
                'error' => 'You do not have the required role(s): ' . implode(', ', $roles)
            ], 403);
        }
        return $next($request);
    }
}
