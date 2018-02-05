<?php

namespace Modules\Auth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Active
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
        if (!empty($request->user()) && !$request->user()->active) {
            auth()->logout();
            $request->session()->invalidate();   
            $error = __('auth::messages.deactivated');
            return redirect()->route('login')->with(compact('error'));
        }        
        return $next($request);
    }
}
