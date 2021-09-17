<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class IsJobSeeker
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
        $user = Auth::user();
        if ($user) {
            if ($user->role == 2) {
                return $next($request);
            }
            return redirect("/")->with("warning", "For only job seeker.");
        }
        return redirect("/")->with("warning", "For only job seeker.");
    }
}
