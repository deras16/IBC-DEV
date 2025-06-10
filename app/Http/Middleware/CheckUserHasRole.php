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
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check() && Auth::user()->roles->first()?->name == null){
            Auth::guard('web')->logout();
            return redirect('/')->with([
                'type' => 'warning',
                'message' => 'You do not have a role assigned. Please contact the administrator to assign you a role.'
            ]);
        }
        return $next($request);
    }
}
