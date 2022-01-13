<?php

namespace App\Http\Middleware;

use App\Exceptions\UnauthorizedException;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @param $role
     * @param $guard
     * @return string|null
     */
    protected function redirectTo($request, Closure $next, $role, $guard = null)
    {
        dd(Auth::guard($guard)->guest());
        if (Auth::guard($guard)->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        // $roles = is_array($role) ? $role : explode('|', $role);
        //
        // if (in_array(Auth::user()->role->role, $roles, true)){
        //     throw UnauthorizedException::forRoles($roles);
        // }

        return $next($request);
    }
}
