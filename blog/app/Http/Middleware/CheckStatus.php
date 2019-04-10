<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckStatus
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
        //if(Auth::check()){
            if(Auth::user()->status == 0){
                return $next($request);
            }
        //}
    
        return redirect()->route('home')->with('error', 'You have been ban from Blog, sorry');
    }
}
