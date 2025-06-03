<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!auth()->check()) {
            abort(403, 'Akses ditolak.');
        }

        $roles = explode('|', $role);
        if (!in_array(auth()->user()->role, $roles)) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
