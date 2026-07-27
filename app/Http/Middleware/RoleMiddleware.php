<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $roles  (comma-separated roles, e.g. "admin,user")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ?string $roles = null): Response
    {
        // Ensure user is logged in
        if (! auth()->check()) {
            abort(403, 'Unauthorized access');
        }

        // If no role parameter was passed to the middleware, deny (or change behavior if you prefer)
        if ($roles === null) {
            abort(403, 'Role not specified for this route');
        }

        // Support multiple roles: "admin,user"
        $allowed = array_map('trim', explode(',', $roles));

        if (in_array(auth()->user()->role, $allowed)) {
            return $next($request);
        }

        abort(403, 'Unauthorized access');
    }
}

