<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

class RoutingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $route): Response
    {
        $user = Auth::user();
        //dd($route);
        //if ($user->role == 'user'){
        //    return $next($request);
        //}
        if($route == 'userlist' && $user->role == 'admin') return $next($request);
        if($route == 'flag' && $user->role == 'admin' || $user->role == 'mod') return $next($request);
        return redirect('/');
    }
}
