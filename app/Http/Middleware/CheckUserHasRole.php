<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$role)
    {
        if (!Auth::check() || !Auth::user()->hasRole($role)) {
            // Optionally, you can use the "with" method to flash data to the session.
            return redirect()->back()->with('error', 'You do not have permission to access this page!.');
        }

        return $next($request);
    }
}
