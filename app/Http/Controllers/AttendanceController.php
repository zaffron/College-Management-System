<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Course;
use App\Department;
use App\Jobs\SendMail;
use App\Register;
use App\Student;
use App\Subject;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Response;
use Validator;
use Mail;

class AttendanceController extends Controller
{
    protected $attn_rules =
        [
            'ver_id' => 'unique'
        ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::all();
        $registers = Register::where('teacher_id', auth()->user()->id)->get();
	    return view('user.attendance', compact('courses', 'registers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $register = Register::findOrFail($request->register_id);
        $attn_date = Carbon::now();
        // Verification date
        $ver_date = Carbon::now()->format('d.m.Y');
        // Plucking out students whoose attendance is already taken
        $taken_students = DB::table($register->tablename)->where('ver_date',$ver_date)->pluck('regno');
        // Taking only those students whoose attendance was not taken
        $students = Student::where([['course', '=', $register->course],['semester', '=', $register->semester],['section', '=', $register->section]])->whereNotIn('regno',$taken_students)->orderBy('name', 'asc')->get();
        return view('user.attendance.create', compact('students','register', 'attn_date', 'ver_date'));
    }

    public function storeEach(Request $request)
    {
        $register = Register::findOrFail($request->register);
        if($request->attendance == 'on' || $request->attendance == "on"){
            $request->attendance = 1;
        }else{
            $request->attendance = 0;
        }
        $date = Carbon::now();
        DB::table($register->tablename)->insert([
            'ver_date' => $request->ver_date,
            'regno' => $request->regno,
            'std_name' => $request->std_name,
            'attendance' => $request->attendance,
            'month' => $date->month,
            'day' => $date->day,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $message['message'] = 'Attendance taken for '.$request->std_name;
        $counter = 0;
        for($i=0;$i<6;$i++){
            $today = Carbon::today()->subDays($i);
            $attendance = DB::table($register->tablename)->whereYear('created_at','=',$today->year)->whereMonth('created_at','=',$today->month)->whereDay('created_at','=',$today->day)->where('regno','=',$request->regno)->where('attendance','=','1')->get();
            if(count($attendance)){
                $counter++;
            }
        }


        return response()->json( $message );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subject = json_decode($request->subject);
        $students = json_decode($request->students);
        $semester = json_decode($request->semester);
        $course = json_decode($request->course);
        $attn_date = $request->attn_date;
        foreach($students as $student)
        {
            $ver_id = $request->ver_date;
            $validate = Attendance::where('ver_id', $ver_id)->first();
            If($validate)
            {
                continue;
            }
            else{
                $id = $student->id;
                if($request->$id)
                {
                    $attendance = new Attendance;
                    $attendance->std_id = $id;
                    $attendance->ver_id = $uid;
                    $attendance->course_id = $course->id;
                    $attendance->semester = $semester;
                    $attendance->attn_date = $attn_date;
                    $attendance->attendance = true;
                    $attendance->updated_by = auth()->user()->id;
                    $attendance->save();
                }else{
                    $attendance = new Attendance;
                    $attendance->ver_id = $uid;
                    $attendance->std_id = $id;
                    $attendance->course_id = $course->id;
                    $attendance->semester = $semester;
                    $attendance->attn_date = $attn_date;
                    $attendance->attendance = false;
                    $attendance->updated_by = auth()->user()->id;
                    $attendance->save();
                }

            }
        }


        return redirect()->back()->with('message', 'Attendance Sucessfully taken !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
