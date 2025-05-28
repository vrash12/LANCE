<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        
        // 1. If not logged in → go to login
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Normalize current role (lowercase)
        $current = Str::lower(trim(Auth::user()->role));
        // Normalize allowed roles (to handle multiple roles)
        $allowed = collect($roles)
            ->flatMap(fn ($r) => explode(',', $r))
            ->map(fn ($r) => Str::lower(trim($r)))
            ->all();

        // 3. Let the correct role pass through
        if (in_array($current, $allowed, true)) {
            return $next($request);
        }

        /*
         |---------------------------------------------------------------
         | NEW: Graceful redirection instead of 403
         |---------------------------------------------------------------
         */
        logger()->notice('RoleMiddleware redirecting user', [
            'user_id' => Auth::id(),
            'role'    => $current,
            'tried'   => $request->fullUrl(),
        ]);

        // Redirection based on user role
        return match ($current) {
            'admin'   => redirect()->route('home'),  // Redirect Admin to home
            'encoder' => redirect()->route('encoder.patients.index'),  // Redirect Encoder to patient records list
            'patient' => redirect()->route('patient.dashboard'),  // Redirect Patient to their dashboard
            default   => redirect('/'),  // Redirect to home for other roles
        };
    }
}
