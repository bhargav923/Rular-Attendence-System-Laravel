<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthCheck
{
    public function handle(Request $request, Closure $next)
    {
        if(!session()->has('school') && ($request->path() != 'login' && $request->path() != 'register')) {
            return redirect('/login')->with('fail','You must be logged in');
        }

        if(session()->has('school') && ($request->path() == 'login' || $request->path() == 'register')) {
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
