<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Blogger
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
        if(Auth::check()){
            if(Auth::user()->role->name === 'blogger' || Auth::user()->role->name === 'administrator'){
                return $next($request);
            }
        }
    
        return redirect()->route('billet.index')->with('error', 'You have not blogger access sorry');
    }
}
