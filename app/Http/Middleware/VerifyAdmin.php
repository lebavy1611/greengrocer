<?php

namespace App\Http\Middleware;

use Closure;

use App\Models\Account;
use Illuminate\Http\Response;
class VerifyAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $manager = auth('api')->user();
        if ($manager->loginable_type != Account::TYPE_ADMIN) {
            $response = [
                'message' => 'Unauthorized'
            ];
            return response($response, Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
