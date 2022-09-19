<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class AddHeaderAccessToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->hasHeader('ana_token')) {
            $request->headers->set('Authorization', 'Bearer ' . $request->header('ana_token'));
           }
           else {//if(!$request->hasHeader("X-Requested-With")){
            return   response()->json('unAuthenticated ',401);

            // throw new AuthenticationException(
            //     'Unauthenticated.',
            // );
           }
           return $next($request);
    }
}
