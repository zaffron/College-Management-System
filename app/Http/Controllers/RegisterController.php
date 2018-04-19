<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Course;
use App\Department;
use App\Register;
use App\Student;
use App\Subject;
use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Response;
use Validator;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $course = auth()->user()->course;
        $semester = $request->semester;
        $subject = $request->subject;
        // get current date
        $now = Carbon::now();
        $year_of_creation = $now->year;
        $month_of_creation = $now->month;
        $teacher_id = auth()->user()->id;
        $section = $request->section;
        $tablename = $course.$subject.$semester.$section.$year_of_creation.$month_of_creation.$teacher_id;

        // Adding into register table
        $register = new Register();
        $register->course = $course;
        $register->subject = $subject;
        $register->semester = $semester;
        $register->section = $section;
        $register->year = $year_of_creation;
        $register->month = $month_of_creation;
        $register->teacher_id = $teacher_id;
        $register->tablename = $tablename;
        $register->save();

        $students = Student::select('id','name','regno')->where([['course','=', $course],['section','=',$section],['semester','=',$semester]])->get()->toArray();

        // Creating table for attendance
        Schema::create($tablename, function (Blueprint $table) {
                $table->increments('id');
                $table->string('regno');
                $table->string('name');
                $table->timestamps();
            });

        DB::table($tablename)->insert($students);

        return response()->json( $register->toArray() );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Register  $register
     * @return \Illuminate\Http\Response
     */
    public function show(Register $register)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Register  $register
     * @return \Illuminate\Http\Response
     */
    public function edit(Register $register)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Register  $register
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Register $register)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Register  $register
     * @return \Illuminate\Http\Response
     */
    public function destroy(Register $register)
    {
        //
    }
}
