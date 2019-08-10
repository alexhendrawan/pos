<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use DB;

class LoginController extends Controller
{
	/*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = '/home';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest')->except('logout');
	}

	public function showLogin(Request $request)
	{
		return view("auth.login");
	}

	public function login(Request $request)
	{
		$input = $request->all();
		unset($input["_token"]);
		unset($input["createdBy"]);
		$client = new Client(['headers' => [
			'Content-Type' => 'application/json'
		]]);
		try {
			$response = $client->post(getenv("BASEURL_API") . "auth/login", [
				'json' => $input
			]);
			// dd($response);
		} catch (\Exception $e) {
			// dd($e);
			return redirect()->back()->withInput($request->all())->with('error', 'Login failed! Something Went Wrong');
		}
		if ($response->getStatusCode() != 200) {

			return redirect('/login')->with('error', 'Login failed! Wrong Email/Password');
		}

		$response = json_decode($response->getBody()->getContents());

		$request->session()->put('apitokenpos', $response->access_token);

		$request->session()->put('user', $response->user);

		return redirect("/");
	}

	public function logout(Request $request)
	{

		$client = new Client(['headers' => [
			'Content-Type' => 'application/json',
			'Authorization' => 'Bearer ' . session()->get('apitokenpos')
		]]);
		try {
			$response = $client->get(getenv("BASEURL_API") . "auth/logout");
		} catch (\Throwable $th) {
			DB::table("sessions")->where("id", "=", session()->getId())->delete();
			return redirect('login')->with('info', 'Logout success!');
		}
		DB::table("sessions")->where("id", "=", session()->getId())->delete();
		return redirect('login')->with('info', 'Logout success!');
	}
}
