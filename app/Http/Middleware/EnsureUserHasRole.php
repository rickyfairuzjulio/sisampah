<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $flatRoles = [];
        foreach ($roles as $r) {
            $flatRoles = array_merge($flatRoles, preg_split('/[|,]/', $r));
        }

        foreach ($flatRoles as $role) {
            $trimmed = trim($role);
            if (!empty($trimmed) && $request->user()->hasRole($trimmed)) {
                return $next($request);
            }
        }

        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}
