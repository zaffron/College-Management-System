<?php

namespace App\Http\Controllers;
use App\User;
use Validator;
use Response;
use App\Department;
use App\Admin;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

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
            'gender' => 'required',
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
        $departments = Department::all();
		return view('admin.user',compact('users','admins', 'departments'));
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
            $user->password = bcrypt($request->password);
            $user->save();
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
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json( $user->toArray() );
    }
}
