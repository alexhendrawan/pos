<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class AddLog
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


        // dd(Auth::user());
        // if(Auth::user() != null){
     if($request->method == "PUT" || $request->method == "DELETE"){
        $arruser = array();
        $arruser["updatedBy"] = Auth::user() ? Auth::user()->username : "System";
        $request->merge($arruser);
    }else{
        $arruser = array();
        $arruser["createdBy"] = Auth::user() ? Auth::user()->username : "System";
        $request->merge($arruser);
    }
        // }
    return $next($request);
}
}
