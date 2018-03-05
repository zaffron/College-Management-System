<?php

namespace App\Http\Controllers;
use Auth;
use Validator;
use Response;
use App\Course;
use App\Admin;
use App\Student;
use App\Subject;
use App\User;
use App\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    protected $rules =
        [
            'name' => 'required|min:2|max:256|regex:/^[a-z ,.\'-]+$/i',
            'username' => 'required|string|max:40|unique:admins',
            'password' => 'required|string|min:4|confirmed',
            'email' => 'required|email|max:255|unique:admins',
            'department' =>'required',
            'gender' => 'required',
        ];

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::all();
        $courses = Course::all();
        $subjects = Subject::all();
        $students = Student::all();
        $users = User::all();
   		return view('admin.home', compact('departments', 'courses', 'subjects', 'students', 'users'));
    }



    public function profile(Admin $id){
        return view('admin.profile');
    }

    public function searchDepartment(Request $request)
    {
        $department = Department::where('name','like','%'.Input::get('query').'%')->orWhere('description', 'like', '%'.Input::get('query').'%')->get();
        foreach($department as $dept){
            $course = Course::findOrFail($dept->course);
            $dept->courseName = $course->name;
        }
        return response()->json( $department->toArray() );
        //Possibility of sql injection here

    }
    public function searchStudent(Request $request)
    {
        $course = Course::where('name', 'Like','%'.Input::get('query').'%')->pluck('id')->toArray();
        $students = Student::where('regno','like','%'.Input::get('query').'%')->orWhere('name', 'like', '%'.Input::get('query').'%')->orWhereIn('course',$course)->get();

        foreach($students as $student)
        {
            $course = Course::findOrFail($student->course);
            $student->courseName = $course->name;
        }
        return response()->json( $students->toArray() );
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make( Input::all(), $this->rules);
        If($validator->fails())
        {
            return Response::json( array(
                'errors' => $validator->getMessageBag()->toArray()
            ));
        }
        else{
            $admin = new Admin();
            $admin->name = $request->name;
            $admin->username = $request->username;
            $admin->gender = $request->gender;
            $admin->email = $request->email;
            $admin->department = $request->department;
            $admin->password = bcrypt($request->password);
            $admin->save();
            return response()->json( $admin->toArray() );
        }
    }

    public function destroy($id)
    {
        $currentUser = Auth::user()->username;
        $admin = Admin::findOrFail($id);
        if($currentUser == $admin->username){
            $message = array("message"=>"An admin cannot delete himself");
            return response()->json($message);
        }
        $admin->delete();

        return response()->json( $admin->toArray() );
    }
}
