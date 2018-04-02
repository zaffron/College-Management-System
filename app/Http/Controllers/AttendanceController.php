<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subject;
use App\Course;
use App\Student;
use App\Department;
use Carbon\Carbon;
use App\Attendance;
use Validator;
use Response;

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
	    return view('user.attendance', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $courses = Course::all();
        $user = auth()->user();
        // Findding the right course
        foreach($courses as $course_traverse){
            if($course_traverse->id == $user->course){
                $course = $course_traverse;
                break;
            }
        }
        foreach($course->subjects as $subject_traverse){
            if($subject_traverse->id == $request->subject){
                $subject = $subject_traverse;
                break;
            }
        }
        $semester = $request->semester;
        $attn_date = Carbon::now();
        // Verification date
        $ver_date = Carbon::now()->format('d.m.Y');
        $students = Student::where([['course', '=', $course->id],['semester', '=', $semester],])->orderBy('name', 'asc')->get();
        return view('user.attendance.create', compact('course', 'subject', 'students', 'semester', 'attn_date', 'ver_date'));
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
            $uid = $request->ver_date . $course->id . $semester . $subject->id . $student->id;
            $validate = Attendance::where('ver_id', $uid)->first();
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
