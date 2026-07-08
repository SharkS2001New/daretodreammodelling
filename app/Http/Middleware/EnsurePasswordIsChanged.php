<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePasswordIsChanged
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user?->must_change_password) {
            return $next($request);
        }

        if ($request->routeIs('password.first-login', 'password.first-login.update', 'logout')) {
            return $next($request);
        }

        return redirect()->route('password.first-login');
    }
}
