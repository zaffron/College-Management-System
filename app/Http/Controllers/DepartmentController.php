<?php

namespace App\Http\Controllers;

use App\Department;
use Validator;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class DepartmentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    protected $rules =
        [
            'name' => 'required|min:2|max:32|regex:/^[a-z ,.\'-]+$/i',
            'description' => 'required|min:2|max:256|regex:/^[a-z ,.\'-]+$/i'
        ];



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     */

    public function index()
    {
	    $datas = Department::all();
	    return view('admin.department', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
		    $department = new Department();
		    $department->name = $request->name;
		    if($request->description != ""){
			    $department->description = $request->description;
		    }
		    else{
		    	$department->description  = 'No description';
		    }
		    $department->save();
		    return response()->json( $department->toArray() );
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
    public function edit( $id)
    {

    }

    public function activate($id)
    {
        $department = Department::findOrFail($id);
        $department->active = 1;
        $department->save();
        return response()->json( $department->toArray() );
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
	        $department              = Department::findOrFail( $id );
	        $department->name        = $request->name;
	        $department->description = $request->description;
	        $department->save();

	        return response()->json( $department->toArray() );
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
	    $department = Department::findOrFail($id);
	    if($department->students_count > 0 || $department->teachers_count > 0)
        {
            $department->active = 0;
            $department->save();
            $department->delete = 0;
        }else{
            $department->delete();
            $department->delete = 1;
        }

	    return response()->json( $department->toArray() );
    }
}
