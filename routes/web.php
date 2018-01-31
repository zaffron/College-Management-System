<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	if(Auth::user()) {
		return view( 'home' );
	}
	return view('auth.login');
});

/*Auth Controller*/
Auth::routes();

 Route::post('admin_login','App\Http\Controllers\Auth\LoginController@login');
 Route::get('admin_login','App\Http\Controllers\Auth\LoginController@showLoginForm');
 Route::post('admin_logout','App\Http\Controllers\Auth\LoginController@logout');
 Route::post('admin_password/email','App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail');
 Route::post('admin_password/reset','App\Http\Controllers\Auth\ResetPasswordController@reset');
 Route::get('admin_password/reset','App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm');
 Route::get('admin_password/reset/{token}','App\Http\Controllers\Auth\ResetPasswordController@showResetForm');
Route::get('admin_register','App\Http\Controllers\Auth\RegisterController@showRegistrationForm');
Route::post('admin_register','App\Http\Controllers\Auth\RegisterController@register');



/*Resource Controller*/
Route::group(['middleware' => 'auth'], function()
{
	Route::resource('student', 'StudentController');
	Route::resource('attendance', 'AttendanceController');
	Route::resource('proctor', 'ProctorController');
	Route::resource('subject', 'SubjectController');
});

Route::get('protected', ['middleware' => ['auth','admin'],function(){
}]);

/*Get Controllers*/
Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/dashboard', 'HomeController@index')->middleware('auth');

Route::get('/admin_home', 'AdminHomeController@index');
