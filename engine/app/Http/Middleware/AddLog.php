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
        // if($request->is('api/v1/*')){
        // dd(Auth::user());

        // }
        if (!$request->is('login') && !$request->is('api/v1/*') ) {

        if ($request->isMethod('put')  || $request->isMethod('delete')) {
            $arruser = array();
            $arruser["updatedBy"] = Auth::user()->displayName;
            // $arruser["branch_id"] = Auth::user()->branch_id;
            $request->merge($arruser);
        } else {
            $arruser = array();
            $arruser["createdBy"] = Auth::user()->displayName;
            // $arruser["branch_id"] = Auth::user()->branch_id;
            $request->merge($arruser);
        }
    }
    //      dd(Auth::user()->username);
    //     // if(Auth::user() != null){
    //  if($request->method == "PUT" || $request->method == "DELETE"){
    //     $arruser = array();
    //     $arruser["updatedBy"] = Auth::user()->username;
    //     $request->merge($arruser);
    // }else{
    //     $arruser = array();
    //     $arruser["createdBy"] = Auth::user()->username;

    //     $request->merge($arruser);
    // }
        // }
    // dd($request->all());    
    return $next($request);
}
}
