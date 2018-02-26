<?php

namespace Modules\Auth\Http\Middleware;

use Closure;
// use Auth;

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
            auth()->logout();
            $request->session()->invalidate();    
            $error = __('auth::messages.unconfirmed');
            return redirect()->route('login')->withErrors($error);
        }
        return $next($request);
    }
}
