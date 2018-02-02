<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AdminLoginController extends Controller
{
	public function __construct()
	{
		$this->middleware('guest:admin');
	}
    public function showLoginForm()
    {
    	return view('auth.admin-login');
    }
    public function login(Request $request)
    {
    	//Validate the form data
    	$this->validate($request,[
    		'username' => 'required|max:255',
    		'password' => 'required|min:6',
    	]);
    	//Attempt to log the user in
    	if(Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password], $request->remember)){
	    	//If successfull, then redirect them to the intended location
	    	return redirect()->intended(route('admin.dashboard'));
    	}
    	//If unsuccessfull, then redirect back to the login with the form data
    	return redirect()->back()->withInput($request->only('username', 'remember'));
    }
}
