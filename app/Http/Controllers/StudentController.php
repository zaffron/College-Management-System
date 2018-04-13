<?php

namespace App\Http\Controllers;

use App\Subject;
use Illuminate\Http\Request;
use App\Student;
use App\Department;
use App\User;
use DB;
use App\Course;
use Intervention\Image\Facades\Image;
use Storage;
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
                'p_contact' => 'required',
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
            'p_contact' => 'required|min:10',
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
        $error_excel = array();
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
                            'section' => $value->section,
                            'course' => $value->course,
                            'semester' => $value->semester,
                            'proctor' => $value->proctor,
                            'p_contact' => $value->contact,
                            'p_email' => $value->p_email,
                            'address' => $value->address,
                            'course' => $value->course,
                            'gender' => $value->gender,
                            'proctor' => $value->proctor,
                        ];
                }
                foreach ($student_list as $key => $value) {
                    $validator = Validator::make( $value, $this->rules);
                    if($validator->fails()){
                        $error = $validator->getMessageBag()->toArray();
                        $errors[] = $error;
                        $error_excel[] = $value;
                        continue;
                    }
                    Student::insert($value);
                    $department = Department::where('course', $value['course'])->first();
                    $department->increment('students_count', 1);
                    $department->save();
                } //for tracing all students
            }else{

                return redirect()->back()->with('error', 'No Entries Found!');
            }//content checking condition
        }else{
            return redirect()->back()->with('errfile', 'No file found');
        }//file checking condition
        if(count($error_excel)>0){
            $excel_file = Excel::create('Students not imported', function($excel) use ($error_excel){
                $excel->sheet('Students not imported', function($sheet) use ($error_excel){
                   $sheet->fromArray($error_excel);
                });
            });

            $excel_file = $excel_file->string('xlsx');
            $response_file = array(
                'name' => 'Discarded Students',
                'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64," . base64_encode($excel_file),

            );

            return response()->json($response_file);
        }

        return back()->with('message', 'All done!');
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
        if($validator->fails())
        {
            return Response::json( array(
                'errors' => $validator->getMessageBag()->toArray()
            ));
        }
        else{
            $student = new Student();
            $course = Course::findOrFail($request->course);
            $student->regno = strtoupper($request->regno);
            $student->name = $request->name;
            $student->email = $request->email;
            $student->contact = $request->contact;
            $student->dob = $request->dob;
            $student->course = $request->course;
            $student->gender = $request->gender;
            $student->proctor = $request->proctor;
            $student->address = $request->address;
            $student->section = $request->section;
            $student->p_contact = $request->p_contact;
            if(isset($request->p_email))
            {
                $student->p_email = $request->p_email;
            }
            // Attaching course with student
            $course->students()->attach($student->id);

            if ($request->hasFile('avatar')) {
                        $image      = $request->file('avatar');
                        $fileName   = time() . '.' . $image->getClientOriginalExtension();

                        $img = Image::make($image->getRealPath());
                        $img->resize(200, 200, function ($constraint) {
                            $constraint->aspectRatio();
                        });

                        $img->stream(); // <-- Key point
                        $student->avatar = $fileName;
                        Storage::disk('local')->put('public/images/students'.'/'.$fileName, $img);
            }
            $student->save();
            $dept = Department::where('course',$student->course)->first();
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
            if($request->course != $student->course){
                // Detaching previous course
                $course = Course::findOrFail($student->course);
                $course->students()->detach($student->id);
                // Making connection to the new one
                $course = Course::findOrFail($request->course);
                $course->students()->attach($student->id);
            }
            $student->regno = strtoupper($request->regno);
            $student->name = $request->name;
            $student->email = $request->email;
            $student->contact = $request->contact;
            $student->dob = $request->dob;
            $student->course = $request->course;
            $student->gender = $request->gender;
            $student->semester = $request->semester;
            $student->proctor = $request->proctor;
            $student->address = $request->address;
            $student->p_contact = $request->p_contact;
            if(isset($request->p_email))
            {
                $student->p_email = $request->p_email;
            }
            if ($request->hasFile('avatar')) {
                        $image      = $request->file('avatar');
                        $fileName   = time() . '.' . $image->getClientOriginalExtension();

                        $img = Image::make($image->getRealPath());
                        $img->resize(200, 200, function ($constraint) {
                            $constraint->aspectRatio();                 
                        });

                        $img->stream(); // <-- Key point
                        $student->avatar = $fileName;
                        Storage::disk('local')->put('public/images/students'.'/'.$fileName, $img);
            }
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
