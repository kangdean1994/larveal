<?php

namespace App\Http\Middleware;

use Closure;

class Message
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
        $value = $request->session()->has('message_name');

        // dd($count);
         if(empty($value)){
            return redirect('Message/add');
        }

       return $next($request);


    }
    
}
