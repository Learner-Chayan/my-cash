<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            return redirect()->back()->with('error', 'You do not have permission to access this page!.');
//            $page_title = "Role Error!";
//            $site_title = BasicSetting::first()->title;
//            return response()->view('errors.role-error', ['page_title' => $page_title,'site_title' => $site_title, 'status' => 403]);


        }

        return $next($request);
    }
}
