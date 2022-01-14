<?php

namespace App\Http\Middleware;

use App\Exceptions\UnauthorizedException;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware extends Middleware
{

    public function handle($request, Closure $next, $guard='sanctum'): ?string
    {
        if (Auth::guard($guard)->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }
        if (!Auth::guard($guard)->user()->role->role === 'administrator'){
            throw UnauthorizedException::forRoles();
        }

        return $next($request);
    }
}
