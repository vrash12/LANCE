<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        // 1. Not logged in → go to login
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Normalise
        $current = Str::lower(trim(Auth::user()->role));
        $allowed = collect($roles)
            ->flatMap(fn ($r) => explode(',', $r))
            ->map(fn ($r) => Str::lower(trim($r)))
            ->all();

        // 3. Let the right roles pass
        if (in_array($current, $allowed, true)) {
            return $next($request);
        }

        /*
         |---------------------------------------------------------------
         |  NEW: graceful redirect instead of 403
         |---------------------------------------------------------------
         */
        logger()->notice('RoleMiddleware redirecting user', [
            'user_id' => Auth::id(),
            'role'    => $current,
            'tried'   => $request->fullUrl(),
        ]);

        return match ($current) {
            'admin'   => redirect()->route('home'),
            'encoder' => redirect()->route('encoder.opd.index'),
            'patient' => redirect()->route('patient.dashboard'),
            default   => redirect('/'),
        };
    }
}
