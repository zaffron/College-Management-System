<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Subject;
use Validator;
use Response;
use Illuminate\Support\Facades\Input;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    protected $rules =
        [
            'name' => 'required|min:2|max:132|regex:/^[a-z ,.\'-]+$/i',
        ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*First i will send all the courses*/
        $courses = Course::all();

        foreach($courses as $course) {
            $course->list = $course->subjects()->get();
            $course->sub_list = $course->subjects()->pluck('subjects.id')->toArray();
        }

        $subjects = Subject::all();
        return view('admin.course', compact('courses', 'subjects'));
    }

    public function addSubjects(Request $request)
    {
        $validator = Validator::make(Input::all(), ['id_course' => 'required', 'name_course' => 'required', 'subjects' => 'required']);
        if($validator->fails())
        {
            return Response::json(array(
               'errors' => $validator->getMessageBag()->toArray()
            ));
        }
        else{
            $course = Course::findOrFail($request->id_course);
            foreach($request->subjects as $id){
                $course->subjects()->attach($id);
            }
            $course->save();
            return response()->json( $course->toArray() );
        }
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
            $course = new Course();
            $course->name = $request->name;
            $course->semester = $request->semester;
            $course->description = $request->description;
            $course->save();
            foreach($request->subjects as $id){
                $course->subjects()->attach($id);
            }
            return response()->json( $course->toArray() );
        }
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
        $validator = Validator::make(Input::all(), $this->rules);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $course              = Course::findOrFail( $id );
            $course->name        = $request->name;
            $course->description = $request->description;
            $course->subjects()->detach();
            foreach($request->subjects as $id){
                $course->subjects()->attach($id);
            }
            $course->save();

            return response()->json( $course->toArray() );
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
        $course = Course::findOrFail($id);
        $course->delete();

        return response()->json( $course->toArray() );
    }
}
