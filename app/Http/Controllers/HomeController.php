<?php

namespace App\Http\Controllers;
use App\Subject;
use Auth;
use App\Course;
use App\User;
use Illuminate\Support\Facades\Input;
use App\Student;
use Illuminate\Http\Request;
use App\Register;
use Carbon\Carbon;
use DB;
use Validator;
use Response;
use Intervention\Image\Facades\Image;
use Storage;



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
                $i = 0;
                while($i < 7)
                {
                    $today = Carbon::today()->subDays($i);
                    $attendance = DB::table($register->tablename)->whereYear('created_at','=',$today->year)->whereMonth('created_at','=',$today->month)->whereDay('created_at','=',$today->day)->where('attendance','=','1')->get();
                    $total_attendance_day[$i] = $today->format("F")." ".$today->day;
                    $total_attendance[$i] = $attendance->count();
                    $i++;
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

