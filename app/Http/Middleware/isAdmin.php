<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class isAdmin
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
            if ($user->role == 1) {
                return $next($request);
            }
            return redirect("/")->with("warning", "You are not an admin.");
        }
        return redirect("/")->with("warning", "You are not an admin.");
    }
}
