<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleUnauthorizedApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->route()->named('sanctum')){
            return $next($request);
        }

        //abort(401, 'Unauthenticated.');
        return response(['status' => false, 'message' => 'Unauthenticated']);
        
    }
}
