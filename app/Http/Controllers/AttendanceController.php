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
use Queue;

class AttendanceController extends Controller
{

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

    public function reportTotal()
    {
        $students = Student::all();
        $year = Carbon::now()->format('Y');
        return view('user.reports.total', compact('students', 'year'));
    }
    public function reportSingle()
    {
        $students = Student::all();
        $year = Carbon::now()->format('Y');

        return view('user.reports.single', compact('students', 'year'));
    }
    public function getTotalData(Request $request)
    {
        $register = Register::where([['course','=',auth()->user()->course],['subject','=',$request->subject],['semester','=',$request->semester],['section','=',$request->section],['year','=', $request->batch]])->first();

        $attendance_table = DB::table($register->tablename)->get();
        $total_class = DB::table($register->tablename)->max('total_class');

        return response()->json( $attendance_table->toArray() );
    }
    public function getSingleData(Request $request)
    {        
        $register = Register::where([['course','=',auth()->user()->course],['subject','=',$request->subject],['semester','=',$request->semester],['section','=',$request->section],['year','=', $request->batch]])->first();

        $attendance_table = DB::table($register->tablename)->where('regno',$request->regno)->first();

        $fields = ['id','regno','name','total_class','attended','created_at','updated_at'];

        $dates = collect($attendance_table)->except($fields);

        $results = array();
        $i=0;
        foreach($dates as $date=>$key)
        {
            $timestamps = new Carbon($request->batch.'-'.$date);
            $results[] = array(
                'id' => (string)$i,
                'title' => (string)$key.' times present in the class',
                'url' => '#',
                'class' => "event-info",
                'start' => (string)$timestamps->timestamp.'000',
            );
        }

        return json_encode($results);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $register = Register::findOrFail($request->register_id);
        $attn_date = Carbon::now()->format('Y-m');
        for($i=0;$i<3;$i++){
            $attn_day[$i] = Carbon::now()->subDays($i)->day;
        }

        // Taking only those students whoose attendance was not taken
        $students = Student::where([['course', '=', $register->course],['semester', '=', $register->semester],['section', '=', $register->section]])->orderBy('name', 'asc')->get();
        
        $todays_column = Carbon::now()->month.'-'.Carbon::now()->day;
        $attendance_taken = 0;
        if(Schema::hasColumn($register->tablename, $todays_column))
        {
            $attendance_taken = DB::table($register->tablename)->max($todays_column);
        }

        return view('user.attendance.create', compact('students','register', 'attn_date','attn_day', 'attendance_taken'));
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
        // Preparing column
        $type = 'integer';
        $autoincrement = false;
        $length = '2';
        $fieldname = $date->month.'-'.$request->day;

        if(Schema::hasColumn($register->tablename, $fieldname))
        {
            // If field is found it should be incremented
            $attendance = DB::table($register->tablename)->where('regno','=',$request->regno)->pluck($fieldname)[0] + $request->attendance;
            DB::table($register->tablename)->where('regno','=',$request->regno)->update([$fieldname => $attendance]);

        }else{
            //If no field is found then that field will be created
            Schema::table($register->tablename, function (Blueprint $table) use ($type, $length, $autoincrement, $fieldname) {
                $table->$type($fieldname,$autoincrement, $length);
            });
            DB::table($register->tablename)->where('regno','=',$request->regno)->insert([
                    $fieldname => $request->attendance,
                ]);

        }
        if($request->attendance){
            DB::table($register->tablename)->where('regno', '=', $request->regno)->update([
                    'total_class' => DB::raw('total_class + 1'),
                    'attended' => DB::raw('attended + 1'),
                ]);
        }else{
            DB::table($register->tablename)->where('regno', '=', $request->regno)->increment('total_class');
        }

        $message['message'] = 'Attendance taken for '.$request->std_name;
        $counter = 0;
        for($i=0;$i<6;$i++){
            $today = Carbon::today()->subDays($i);
            if(Schema::hasColumn($register->tablename,$today->month.'-'.$today->day))
            {
                $attendance = DB::table($register->tablename)->where('regno','=',$request->regno)->pluck($today->month.'-'.$today->day);
            }
            if($attendance[0]){
                $counter++;
            }
        }
        if($counter < 1){
            $student = Student::where('regno', $request->regno)->first();
            $data['title'] = 'Missing attendance!';
            $data['subject'] = 'Your child\'s missing attendance!';
            $data['content'] = 'Your child '.$student->name.' hasn\'t attended any class this week. Please enquire with your child for the timely remedy. Otherwise he will fall short on attendance';
            $data['email'] = $student->p_email;
            $data['name'] = $student->name.' parent';

            $sms['name'] = $student->name;
            $sms['contact'] = $student->p_contact;
            dispatch(new SendMail($data, $sms));
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
