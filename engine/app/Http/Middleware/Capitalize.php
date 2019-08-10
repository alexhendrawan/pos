<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class Capitalize
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

      if(!strpos(\Request::getRequestUri(), "login")){
        foreach ($request->all() as $key=>$value) {
          if($key != "_token"){
            $convert = strtolower($value);
            $result = ucwords($convert); 
            $new = array();
            $new[$key]=$result;
            $request->merge($new);
          }
        }
      }
      return $next($request);
    }
  }
