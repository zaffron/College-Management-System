<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Auth;

class AdminLoginController extends Controller
{
	public function __construct()
	{
		$this->middleware('guest');
	}
    public function showLoginForm()
    {
    	return view('auth.admin-login');
    }
    public function login(Request $request)
    {
    	//Validate the form data
    	$this->validate($request,[
    		'username' => 'required',
    		'password' => 'required',
    	]);
    	//Attempt to log the user in
    	if(Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password], $request->remember)){
	    	//If successfull, then redirect them to the intended location
	    	return redirect()->intended(route('admin.dashboard'))	;
    	}
    	//If unsuccessfull, then redirect back to the login with the form data
    	return redirect()->back()->withInput($request->only('username', 'remember','errors'));
    }


	/**
	 * Log the user out of the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function logout(Request $request)
	{
		auth('admin')->logout();
		$request->session()->flush();
		$request->session()->regenerate();
		return redirect()->guest(route( 'admin.login' ));
	}
}
