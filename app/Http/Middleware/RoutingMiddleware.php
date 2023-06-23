<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

class RoutingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, /*$route*/): Response
    {
        $user = Auth::user();
        if ($user->role == 'user'){
            return $next($request);
        }
        return redirect()->back()->with('flash_message','you are not allowed to access this');
    }
}
