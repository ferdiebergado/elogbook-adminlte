<?php

namespace Modules\Auth\Http\Middleware;

use Closure;
use Auth;

class UserEmailConfirmed
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
        if (!empty($request->user()) && !$request->user()->confirmed) {
            Auth::logout();
            $request->session()->invalidate();        
            return redirect('/login');
        }
        return $next($request);
    }
}
