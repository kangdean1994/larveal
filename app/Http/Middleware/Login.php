<?php

namespace App\Http\Middleware;

use Closure;

class Login
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
        //前置
        // echo 111;
    $count = $request->session()->has('register_name');

     // dd($count);
    if(empty($count)){
        return redirect('Admin/login');
    }else{
        
    }
   return $next($request);
    }
}
