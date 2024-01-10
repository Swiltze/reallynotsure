<?php

// app/Http/Middleware/EnsureUserIsAdmin.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === User::ROLE_ADMIN) {
            return $next($request);
        }

        // If the user is not an admin, you can abort or redirect
        abort(403, 'Unauthorized action.');
    }
}
