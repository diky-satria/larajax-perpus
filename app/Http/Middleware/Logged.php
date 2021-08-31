<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Logged
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
        if(Auth::user()){
            if(Auth::user()->role == 'super admin' || Auth::user()->role == 'admin'){
                return redirect('dashboard');
            }else{
                return redirect('mahasiswa');
            }
        }
        return $next($request);
    }
}
