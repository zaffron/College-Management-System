<?php

namespace App\Http\Controllers;
use App\Course;
use App\Department;
use App\GraduatedStudent;
use App\Register;
use App\Student;
use App\Subject;
use App\User;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Schema;
use Intervention\Image\Facades\Image;
use Response;
use Storage;
use Validator;



class HomeController extends Controller
{
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

    protected $proctee_update_rules = 
        [
            'email' => 'required|email|max:255',
            'contact' => 'required|min:10|max:13',
            'parent_contact' => 'required|min:10|max:13',
            'address' => 'required|min:2|max:255',
        ];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*Profile handling for user*/
    public function profile(User $id){

        return view('user.profile');
    }

    public function updateProfile(Request $request, $id)
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
                $user = User::findOrFail($id);
                $user->name = $request->name;
                $user->gender = $request->gender;
                $user->email = $request->email;
                $user->password = bcrypt($request->password);
                if ($request->hasFile('avatar')) {
                            $image      = $request->file('avatar');
                            $fileName   = time() . '.' . $image->getClientOriginalExtension();

                            $img = Image::make($image->getRealPath());
                            $img->resize(200, 200, function ($constraint) {
                                $constraint->aspectRatio();                 
                            });

                            $img->stream(); // <-- Key point
                            $user->avatar = $fileName;
                            Storage::disk('local')->put('public/images/profile'.'/'.$fileName, $img);
                }
                $user->save();
                return response()->json( $user->toArray() );
            }
        }else{
            $validator = Validator::make( Input::all(), $this->profile_update_rules);
            if($validator->fails())
            {
                return Response::json( array(
                    'errors' => $validator->getMessageBag()->toArray()
                ));
            }else{
                $user = user::findOrFail($id);
                $user->name = $request->name;
                $user->gender = $request->gender;
                $user->email = $request->email;
                if ($request->hasFile('avatar')) {
                            $image      = $request->file('avatar');
                            $fileName   = time() . '.' . $image->getClientOriginalExtension();

                            $img = Image::make($image->getRealPath());
                            $img->resize(200, 200, function ($constraint) {
                                $constraint->aspectRatio();                 
                            });

                            $img->stream(); // <-- Key point
                            $user->avatar = $fileName;
                            Storage::disk('local')->put('public/images/profile'.'/'.$fileName, $img);
                }
                $user->save();
                return response()->json( $user->toArray() );
            }
        }
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
            $registers = Register::all();
            // Get last 7 day attendance
            foreach($registers as $register){
                $total_attendance = array();
                $j = 6;
                for($i=0;$i<7;$i++)
                {
                    $today = Carbon::today()->subDays($j);
                    $attendance = 0;
                    if(Schema::hasColumn($register->tablename,$today->month.'-'.$today->day))
                    {
                        $attendance = DB::table($register->tablename)->where($today->month.'-'.$today->day,'>',0)->pluck($today->month.'-'.$today->day)->count();
                    }
                    $total_attendance_day[$i] = $today->format("F")." ".$today->day;
                    $total_attendance[$i] = $attendance;
                    $j--;
                }
                $register->total_attendance = json_encode($total_attendance);
                $register->total_attendance_day = json_encode($total_attendance_day);
            }
            $current_date = Carbon::now();
            
    		return view('home', compact('users', 'students', 'subjects', 'courses','registers', 'current_date'));
	    }
	    return view('login');
    }
    public function showStudents()
    {
        $students = Student::all();
        $courses = Course::all();
        $departments = Department::all();
        $users = User::all();

        return view('user.student', compact('students', 'courses', 'departments', 'users'));
    }
    public function graduated()
    {
        $students = GraduatedStudent::all();
        $courses = Course::all();
        $departments = Department::all();
        $users = User::all();

        return view('user.graduated', compact('students', 'courses', 'departments', 'users'));
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
    
    public function searchGraduated()
    {
        $course = Course::where('name', 'Like','%'.Input::get('query').'%')->pluck('id')->toArray();
        $students = GraduatedStudent::where('regno','like','%'.Input::get('query').'%')->orWhere('name', 'like', '%'.Input::get('query').'%')->orWhereIn('course',$course)->get();

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
        $departments = \App\Department::all();
        $users = \App\User::all();
        return view('user.proctees', compact('courses', 'departments', 'users'));
    }

    public function procteeUpdate(Request $request)
    {
        $validator = Validator::make( Input::all(), $this->proctee_update_rules);
        if($validator->fails())
        {
            return Response::json( array(
                'errors' => $validator->getMessageBag()->toArray()
            ));
        }
        $student = Student::where('regno', $request->regno)->first();
        $student->email = $request->email;
        $student->contact = $request->contact;
        $student->p_contact = $request->parent_contact;
        $student->p_email = $request->parent_email;
        $student->address = $request->address;
        $student->save();

        return back()->with('message', 'Proctee Details Updated!');
    }
}

