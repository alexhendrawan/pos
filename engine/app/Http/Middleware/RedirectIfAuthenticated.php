<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use DB;

class RedirectIfAuthenticated
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param  string|null  $guard
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = null)
	{
		// if (Auth::guard($guard)->check()) {
		//     return redirect('/home');
		// }
		// $data = DB::table("sessions")->where("id", "=", session()->getId())->delete();
		if (!$request->is('login')) {
			if (session()->get('apitokenpos') == null) {
				return redirect('login')->with("error", "Something Wrong! Read Manual Book! Code : 401");
			}
		}
		return $next($request);
	}
}
