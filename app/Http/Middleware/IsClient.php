<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class IsClient
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
        if (Auth::user()) {
            foreach (Auth::user()->roles as $role) {
                if ($role->name == 'Client') {
                    return $next($request);
                }
            }
        }
        return response()->json(['error' => 'Unauthorized'], 403);
    }
}
