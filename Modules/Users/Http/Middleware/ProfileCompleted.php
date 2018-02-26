<?php

namespace Modules\Users\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ProfileCompleted
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
        if (!empty($request->user()) && (!$request->user()->jobtitle_id || !$request->user()->office_id)) {
            $error = __('users::messages.profile_incomplete');
            return redirect()->route('users.edit', $request->user()->id)->withErrors($error);
        }        
        return $next($request);
    }
}
