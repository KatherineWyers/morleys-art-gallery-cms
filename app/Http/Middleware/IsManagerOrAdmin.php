<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class IsManagerOrAdmin
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
        if (Auth::guest())
        {
            return response('Unauthorized. You must be logged in as a manager or admin to view this area.<br /><a href="/"><< Back to Home</a>', 401);
        }

        // Calls the isManager method in User model
        if((Auth::user()->isManager() == false) && (Auth::user()->isAdmin() == false)) {
            return response('Unauthorized. You must be logged in as a manager or admin to view this area.<br /><a href="/"><< Back to Home</a>', 401);
        }
        
        return $next($request);
    }

}
