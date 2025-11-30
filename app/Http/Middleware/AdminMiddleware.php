<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and has admin role
        if (Auth::check()) {
            try {
                if (Auth::user()->hasRole('admin')) {
                    return $next($request);
                }
            } catch (\Exception $e) {
                // Ignore hasRole errors
            }
        }

        abort(403, 'Unauthorized access');
    }
}
