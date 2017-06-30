<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;

use App\User;

use Closure;

class isAdminMiddleware
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
        if(!Auth::guest()){
            return redirect($next);
        }

        return redirect()->route('adminLogin');
    }
}
