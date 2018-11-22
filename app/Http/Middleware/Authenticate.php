<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request the application request
     * @param \Closure                 $next    the callback after middleware
     * @param string|null              $guard   the authentication guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            $response = [
                'message' => 'Unauthorized'
            ];
            return response($response, 401);
        }

        return $next($request);
    }
}
