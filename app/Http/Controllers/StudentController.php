<?php

namespace App\Http\Controllers;

use App\Subject;
use Illuminate\Http\Request;
use App\Student;
use App\Department;
use App\User;
use DB;
use App\Course;
use Excel;
use Validator;
use Illuminate\Support\Facades\Input;
use Response;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function rules($id)
    {
        $student = Student::findOrFail($id);
        return
            [
                'name' => 'required|min:2|max:32',
                'email' => 'email|required|unique:students,email,'.$student->id,
                'regno' => 'required|min:10|unique:students,regno,'.$student->id,
                'contact' => 'required|min:10',
                'dob' => 'required',
                'course' => 'required',
                'gender' => 'required',
                'proctor' => 'required',
            ];
    }
    protected $rules =
        [
            'name' => 'required|min:2|max:32',
            'email' => 'email|required|unique:students',
            'regno' => 'required|min:10|unique:students',
            'contact' => 'required|min:10',
            'dob' => 'required',
            'course' => 'required',
            'gender' => 'required',
            'proctor' => 'required',
        ];


    /**
     * Display a listing of the resource.
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
        return view('admin.student', compact('departments','subjects', 'courses','users', 'students'));
    }

    public function studentsExport($type)
    {
        $data = Student::get()->toArray();
        return Excel::create('Students Details', function($excel) use ($data){
            $excel->sheet('Students Details', function($sheet) use ($data){
               $sheet->fromArray($data);
            });
        })->export($type);
    }

    public function studentsImport(Request $request)
    {
        if($request->hasFile('students')){
            $path = $request->file('students')->getRealPath();
            $data = \Excel::load($path)->get();
            if($data->count()){
                foreach($data as $key => $value){
                    $student_list[] =
                        [
                            'name' => $value->name,
                            'regno' => strtoupper($value->regno),
                            'email' => $value->email,
                            'contact' => $value->contact,
                            'dob' => $value->dob,
                            'course' => $value->course,
                            'gender' => $value->gender,
                            'proctor' => $value->proctor,
                        ];
                }
                if(!empty($student_list)){
                    Student::insert($student_list);
                    \Session::flash('success', 'File imported successfully');
                }
            }else{
                \Session::flash('warning', 'There is no file to import');
            }
        }
        return redirect()->back();
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
            $student = new Student();
            $student->regno = strtoupper($request->regno);
            $student->name = $request->name;
            $student->email = $request->email;
            $student->contact = $request->contact;
            $student->dob = $request->dob;
            $student->course = $request->course;
            $student->gender = $request->gender;
            $student->proctor = $request->proctor;
            $student->save();
            $course = Course::findOrFail($student->course);
            $dept = Department::where('course'.'='.$course->id)->get();
            $dept->students_count += 1;
            $dept->save();
            $student->courseName = $course->name;
            return response()->json( $student->toArray() );
        }
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
        $validator = Validator::make(Input::all(), $this->rules($id));
        if($validator->fails()){
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {
            $student = Student::findOrFail($id);
            $student->name = $request->name;
            $student->regno = $request->regno;
            $student->email = $request->email;
            $student->contact = $request->contact;
            $student->dob = $request->dob;
            $student->gender = $request->gender;
            $student->proctor = $request->proctor;
            $student->course = $request->course;
            $student->save();
            $course = Course::findOrFail($student->course);
            $student->courseName = $course->name;
            return response()->json( $student->toArray() );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $dept = Department::findOrFail($student->course);
        $student->delete();
        $dept->students_count -= 1;
        $dept->save();

        return response()->json( $student->toArray() );
    }
}
