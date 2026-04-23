<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!$request->user()) {
            return redirect('/login');
        }

        $allowedRoles = [];
        foreach ($roles as $role) {
            $allowedRoles = array_merge($allowedRoles, explode('|', $role));
        }

        $userRole = $request->user()->role?->slug;

        if (!in_array($userRole, $allowedRoles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}