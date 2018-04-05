<?php

namespace App\Http\Controllers;
use App\Subject;
use Auth;
use App\Course;
use App\User;
use Illuminate\Support\Facades\Input;
use App\Student;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	if(Auth::check()){
    	    $users = User::all();
    	    $students = Student::all();
    	    $subjects = Subject::all();
    	    $courses = Course::all();
    		return view('home', compact('users', 'students', 'subjects', 'courses'));
	    }
	    return view('login');
    }
    public function showStudents()
    {
        $students = Student::all();
        $courses = Course::all();

        return view('user.student', compact('students', 'courses'));
    }
    public function searchStudents()
    {
        $course = Course::where('name', 'Like','%'.Input::get('query').'%')->pluck('id')->toArray();
        $students = Student::where('regno','like','%'.Input::get('query').'%')->orWhere('name', 'like', '%'.Input::get('query').'%')->orWhereIn('course',$course)->get();

        foreach($students as $student)
        {
            $course = Course::findOrFail($student->course);
            $proctor = User::findOrFail($student->proctor);
            $student->courseName = $course->name;
            $student->proctorName = $proctor->name;
        }
        return response()->json( $students->toArray() );
    }
    public function proctees()
    {
        $courses = Course::all();
        return view('user.proctees', compact('courses'));
    }
}

