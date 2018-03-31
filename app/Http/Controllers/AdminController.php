<?php

namespace App\Http\Controllers;
use Auth;
use Validator;
use Response;
use App\Course;
use App\Admin;
use App\Student;
use App\Subject;
use Storage;
use App\User;
use Intervention\Image\Facades\Image;
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
    protected $profile_update_rules = 
        [
            'name' => 'required|min:2|max:256|regex:/^[a-z ,.\'-]+$/i',
            'email' => 'required|email|max:255',
            'gender' =>'required',
        ];
    protected $profile_update_rules_password =
        [
            'name' => 'required|min:2|max:256|regex:/^[a-z ,.\'-]+$/i',
            'email' => 'required|email|max:255',
            'gender' =>'required',
            'password' =>'required|min:6|max:255',
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


    /*Profile handling*/
    public function profile(Admin $id){

        return view('admin.profile');
    }


    public function announcement()
    {
        $departments = Department::all();
        $courses = Course::all();
        $subjects = Subject::all();
        $students = Student::all();
        $users = User::all();
        return view('admin.announcement', compact('departments', 'courses', 'subjects', 'students', 'users'));
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

    public function update(Request $request, $id)
    {
        if($request->password != '' || $request->password != "")
        {
            $validator = Validator::make( Input::all(), $this->profile_update_rules_password);
            if($validator->fails())
            {
                return Response::json( array(
                    'errors' => $validator->getMessageBag()->toArray()
                ));
            }else{
                $admin = Admin::findOrFail($id);
                $admin->name = $request->name;
                $admin->gender = $request->gender;
                $admin->email = $request->email;
                $admin->description = $request->description;
                $admin->password = bcrypt($request->password);
                if ($request->hasFile('avatar')) {
                            $image      = $request->file('avatar');
                            $fileName   = time() . '.' . $image->getClientOriginalExtension();

                            $img = Image::make($image->getRealPath());
                            $img->resize(200, 200, function ($constraint) {
                                $constraint->aspectRatio();                 
                            });

                            $img->stream(); // <-- Key point
                            $admin->avatar = $fileName;
                            Storage::disk('local')->put('images/profile'.'/'.$fileName, $img, 'public');
                }
                $admin->save();
                return response()->json( $admin->toArray() );
            }
        }else{
            $validator = Validator::make( Input::all(), $this->profile_update_rules);
            if($validator->fails())
            {
                return Response::json( array(
                    'errors' => $validator->getMessageBag()->toArray()
                ));
            }else{
                $admin = Admin::findOrFail($id);
                $admin->name = $request->name;
                $admin->gender = $request->gender;
                $admin->email = $request->email;
                $admin->description = $request->description;
                $admin->save();
                return response()->json( $admin->toArray() );
            }
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
