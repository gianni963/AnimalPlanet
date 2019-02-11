<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check() && Auth::user()->isAdmin() && Auth::user()->hasAdminTitle())
        {
            return $next($request);
        }
        abort(403,'You do not have permission to perform this action.');
        //return redirect('home');
        
    }
}
