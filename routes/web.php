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
		route('home');
	}
	return view('auth.login');
});

/*Auth Controller*/
Auth::routes();

// Notification mark as read
Route::get('/markAsReadUser/{id}', function($id){
   auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
});

//Attendance report
Route::get('/attendance/reportTotal', 'AttendanceController@reportTotal')->middleware('auth')->name('attendance.report.total');
Route::get('/attendance/reportSingle', 'AttendanceController@reportSingle')->middleware('auth')->name('attendance.report.single');
Route::post('/report/getTotalData', 'AttendanceController@getTotalData')->middleware('auth');
Route::post('/report/getSingleData', 'AttendanceController@getSingleData')->middleware('auth');
/*User Controllers*/
Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/dashboard', 'HomeController@index')->middleware('auth');
Route::get('/students', 'HomeController@showStudents')->middleware('auth')->name('user.students');
Route::post('/search/student', 'HomeController@searchStudents')->middleware('auth');
// Related to proctees
Route::get('/proctees', 'HomeController@proctees')->middleware('auth')->name('user.proctees');
Route::post('/proctee/update', 'HomeController@procteeUpdate')->middleware('auth');

Route::resource('attendance', 'AttendanceController');
Route::resource('course', 'CourseController');
Route::resource('user', 'UserController');
Route::resource('department', 'DepartmentController');

// Student controller
Route::resource('student', 'StudentController');
Route::get('student/graduated', 'HomeController@graduated')->middleware('auth')->name('user.graduated');
Route::post('/search/graduated', 'HomeController@searchGraduated')->middleware('auth');

Route::resource('subject', 'SubjectController');
Route::resource('register', 'RegisterController');
Route::post('/attendance/register/storeEach', 'AttendanceController@storeEach');
Route::post('/changeUserTheme/{status}', function($status){
    $user = auth()->user();
    $user->d_mode = $status;
    $user->save();
    return back()->with('Message', 'Success');
})->middleware('auth');



/*User profile*/
Route::get('/profile/{id}', 'HomeController@profile')->name('user.profile');
Route::post('/profile/{id}', 'HomeController@updateProfile')->name('user.profile.update');



/*Admin Routes*/
Route::prefix('admin')->group(function(){
	Route::post('/login','Auth\AdminLoginController@login')->name('admin.submit');
	Route::get('/login','Auth\AdminLoginController@showLoginForm')->name('admin.login');
	Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
    Route::post('/create', 'AdminController@store')->name('admin.store');
    Route::delete('/destroy/{id}', 'AdminController@destroy')->name('admin.destroy');
    Route::get('/', 'AdminController@index')->name('admin.dashboard');
    Route::post('/search/department', 'AdminController@searchDepartment')->name('admin.search.department');
    Route::post('/search/student', 'AdminController@searchStudent')->name('admin.search.student');
    // Graduate students
    Route::get('student/graduated', 'AdminController@graduated')->middleware('auth:admin')->name('admin.graduated');
    Route::post('search/graduated', 'AdminController@searchGraduated');

    // Changing theme mode for admin
    Route::post('/changeAdminTheme/{status}', function($status){
        $user = auth()->user();
        $user->d_mode = $status;
        $user->save();
        return back()->with('Message', 'Success');
    })->middleware('auth:admin');

    // Notification mark as read
    Route::get('/markAsReadAdmin/{id}', function($id){
       auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
    })->middleware('auth:admin');


    /*Admin profile*/
    Route::get('/profile/{id}', 'AdminController@profile')->name('admin.profile');
    Route::post('/profile/{id}', 'AdminController@update')->name('admin.profile.update');

    // Announcement
    Route::get('/announcement', 'AdminController@announcement')->name('admin.announcement');
    Route::post('/announcement/create', 'AdminController@createAnnouncement')->name('admin.announcement.create');
    Route::post('/announcement/semester', 'AdminController@semesterEnd')->name('admin.announcement.semester')->middleware('auth:admin');

    //Course
    Route::post('course/addSubjects', 'CourseController@addSubjects');


    /*Import export using CSV and XLS*/
    Route::post('/postImport', 'StudentController@studentsImport');
    Route::post('/postExport/{type}', 'StudentController@studentsExport')->name('student.export');

    //Department
    Route::post('/department/activate/{id}', 'DepartmentController@activate');

    Route::resource('course', 'CourseController');
	Route::resource('user', 'UserController');
	Route::resource('department', 'DepartmentController');
	Route::resource('student', 'StudentController');
	Route::resource('subject', 'SubjectController');
});




/* Route::post('admin_password/email','App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail');
 Route::post('admin_password/reset','App\Http\Controllers\Auth\ResetPasswordController@reset');
 Route::get('admin_password/reset','App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm');
 Route::get('admin_password/reset/{token}','App\Http\Controllers\Auth\ResetPasswordController@showResetForm');
*/


