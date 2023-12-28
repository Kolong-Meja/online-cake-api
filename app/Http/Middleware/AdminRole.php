<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check() || Auth::user()->role->title !== $role) {
            return response()->json([
                'success' => false,
                'statusCode', 403,
                'message' => "Access denied! you don't have the required role $role",
                'content' => null
            ], 403);
        }

        return $next($request);
    }
}
