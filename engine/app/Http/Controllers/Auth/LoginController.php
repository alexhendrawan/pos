<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use DB;


// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
// use App\Http\Controllers\Controller;

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
		dd("a");
		return view("auth.login");
	}

	public function login(Request $request)
	{
		// $input = $request->all();
		// unset($input["_token"]);
		// unset($input["createdBy"]);
		// $client = new Client(['headers' => [
		// 	'Content-Type' => 'application/json'
		// ]]);
		// try {
		// 	$response = $client->post(getenv("BASEURL_API") . "auth/login", [
		// 		'json' => $input
		// 	]);
		// 	// dd($response);
		// } catch (\Exception $e) {
		// 	// dd($e);
		// 	return redirect()->back()->withInput($request->all())->with('error', 'Login failed! Something Went Wrong');
		// }
		// if ($response->getStatusCode() != 200) {

		// 	return redirect('/login')->with('error', 'Login failed! Wrong Email/Password');
		// }

		// $response = json_decode($response->getBody()->getContents());

		// $request->session()->put('apitokenpos', $response->access_token);

		// $request->session()->put('user', $response->user);

		// return redirect("/");
		// validate the info, create rules for the inputs
        $rules = array(
            'username' => 'required', // make sure the email is an actual email
            'password' => 'required' // password can only be alphanumeric and has to be greater than 3 characters
        );
        // run the validation rules on the inputs from the form
        $validator = validator($request->all(), $rules);
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return redirect('login')
                ->withErrors($validator) // send back all errors to the login form
                ->withInput($request->except('password')); // send back the input (not the password) so that we can repopulate the form
        } else {
            // dd("");
            // create our user data for the authentication
            $userdata = array(
                'username'     => $request->username,
                'password'  => $request->password
            );

            // attempt to do the login
            if (Auth::guard()->attempt($userdata)) {
                // $this->addAbsensi_masuk($request);
                // validation successful!
                // redirect them to the secure section or whatever
                // return Redirect::to('secure');
                // for now we'll just echo success (even though echoing in a controller is bad)
                //echo 'SUCCESS!';
                return redirect()->intended('/')->with('message', 'Login Sukses');
            } else {
                // validation not successful, send back to form
                return redirect('/login')->with('error', 'Login Ulang, name atau Password anda salah');
            }
        }
	}

	public function logout(Request $request)
	{

		// $client = new Client(['headers' => [
		// 	'Content-Type' => 'application/json',
		// 	'Authorization' => 'Bearer ' . session()->get('apitokenpos')
		// ]]);
		// try {
		// 	$response = $client->get(getenv("BASEURL_API") . "auth/logout");
		// } catch (\Throwable $th) {
		// 	DB::table("sessions")->where("id", "=", session()->getId())->delete();
		// 	return redirect('login')->with('info', 'Logout success!');
		// }
		// DB::table("sessions")->where("id", "=", session()->getId())->delete();
		// return redirect('login')->with('info', 'Logout success!');
		 Auth::logout(); // log the user out of our application
        return redirect('login')->with('message', 'Logout Success'); // redirect the user to the login screen
	}
}
