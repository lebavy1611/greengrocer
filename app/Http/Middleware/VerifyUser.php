<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Account;
use Illuminate\Http\Response;

class VerifyUser
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
        $user = auth('api')->user();
        if ($user){
            if($user->loginable_type != Account::TYPE_USER) {
                $response = [
                    'message' => 'Unauthorized'
                ];
                return response($response, Response::HTTP_UNAUTHORIZED);
            }   
        } else {
            $response = [
                'message' => 'Unauthorized, please Login'
            ];
            return response($response, Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
