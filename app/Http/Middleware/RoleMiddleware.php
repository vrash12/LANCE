<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Usage:  ->middleware('role:admin')  or  'role:admin,encoder'
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }

        abort(403, 'Unauthorized.');
    }
}
