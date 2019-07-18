<?php

namespace App\Http\Middleware;

use Closure;

class Goods
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
        //前置 要时间在9时之前
        $time = time();
        $a = strtotime('9:00:00');
        // dd($a);
        $b = 7;
        // dd($b);
        if($time<$a){
            echo "该页面在九点后可进入";die;
            //后置  要时间在17时之后
        }else if($time>$b){
            echo "该页面在五点前可进入";die;
        }

        
        return $next($request);
    }
}
