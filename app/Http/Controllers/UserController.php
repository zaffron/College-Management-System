<?php

namespace App\Http\Controllers;
use App\User;
use Validator;
use Response;
use App\Department;
use App\Admin;
use App\Subject;
use App\Course;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    protected $rules =
        [
            'name' => 'required|min:2|max:256|regex:/^[a-z ,.\'-]+$/i',
            'username' => 'required|string|max:40|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'email' => 'required|email|max:255|unique:users',
            'department' =>'required',
            'gender' => 'required',
        ];
    protected $edit_rules = 
        [
            'name' => 'required|min:2|max:256|regex:/^[a-z ,.\'-]+$/i',
            'email' => 'required|email|max:255',
            'department' =>'required',
            'subjects' =>'required',
            'course' => 'required',
            'gender' => 'required',
        ];

    protected $profile_update_rules = 
        [
            'name' => 'required|min:2|max:256|regex:/^[a-z ,.\'-]+$/i',
            'email' => 'required|email|max:255',
            'gender' =>'required',
            'password' =>'required',
        ];
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $admins = Admin::all();
        $courses = Course::all();
        $subjects = subject::all();
        $departments = Department::all();
        foreach($users as $user) {
            $user->list = $user->subjects()->get();
            $user->sub_list = $user->subjects()->pluck('subjects.id')->toArray();
        }
		return view('admin.user',compact('users','admins','subjects','courses','departments'));
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
        $validator = Validator::make( Input::all(), $this->rules);
        If($validator->fails())
        {
            return Response::json( array(
                'errors' => $validator->getMessageBag()->toArray()
            ));
        }
        else {
            $user = new User();
            $user->name = $request->name;
            $user->username = $request->username;
            $user->gender = $request->gender;
            $user->email = $request->email;
            $user->department = $request->department;
            if($request->course)
                $user->course = $request->course;
            $user->password = bcrypt($request->password);
            //Adding teacher count after adding user
            $department = Department::findOrFail($request->department);
            $department->teachers_count = $department->teachers_count + 1;
            $department->save();
            $user->save();
            foreach($request->subjects as $id){
                $user->subjects()->attach($id);
            }
            return response()->json($user->toArray());
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
        $validator = Validator::make( Input::all(), $this->edit_rules);
        If($validator->fails())
        {
            return Response::json( array(
                'errors' => $validator->getMessageBag()->toArray()
            ));
        }
        else {
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->gender = $request->gender;
            $user->email = $request->email;
            $department = Department::findOrFail($user->department);
            $department->teachers_count = $department->teachers_count - 1;
            $user->department = $request->department;
            $user->course = $request->course;
            //Adding teacher count after adding user
            $department = Department::findOrFail($request->department);
            $department->teachers_count = $department->teachers_count + 1;
            $department->save();
            $user->save();
            $user->subjects()->detach();
            foreach($request->subjects as $id){
                $user->subjects()->attach($id);
            }
            return response()->json($user->toArray());
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
        $user = User::findOrFail($id);
        //Adding teacher count after adding user
        $department = Department::findOrFail($user->department);
        $department->teachers_count =- 1;
        $department->save();
        $user->delete();

        return response()->json( $user->toArray() );
    }
}
