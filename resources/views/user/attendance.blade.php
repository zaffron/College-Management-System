@extends('layouts.layout')

@section('content')
    <div class="container">
        <div class="col-md-12 card bg-dark text-white">
            <div class="card-body">
                <h4 class="card-title"><span class="fa fa-book"></span> Registers</h4>
                <hr>
                <p class="card-text">Create register to take attendance</p>
                <button type="button" data-toggle="modal" data-target="#createRegister" class="btn btn-md btn-primary text-white"> Create Register <i class="fa fa-book" aria-hidden="true"></i></button>
            </div>
        </div>
        <div class="col-md-12">
            <table class="table table-striped text-center">
                <tr>
                    <th>#</th>
                    <th>Course</th>
                    <th>Subject</th>
                    <th>Semester</th>
                    <th>Section</th>
                    <th>Year</th>
                    <th>Attendance</th>
                </tr>
                @foreach($registers as $register)
                    <tr>
                        <td>{{ $register->id }}</td>
                        <td>{{ $register->courses->name }}</td>
                        <td>{{ $register->subjects->name }}</td>
                        <td>{{ $register->semester }}</td>
                        <td>{{ $register->section }}</td>
                        <td>{{ $register->year }}</td>
                        <td style="margin: 0;padding:0;padding-top:10px;">
                            <form method="GET" action="{{ route('attendance.create') }}">
                                {{ csrf_field() }}
                                <input type="text" name="register_id" value="{{ $register->id }}" hidden="hidden">
                                <button class="btn btn-info btn-sm take-attendance" data-id="{{ $register->id }}"><span class="fa fa-check"></span> Take Attendance</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
@endsection

@section('modals')
    {{--Add modal for creating register--}}
    <div class="modal fade" id="createRegister" tabindex="-1" role="dialog" aria-labelledby="createRegister" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Register:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form  method="POST">
                        <div class="from-group row">
                            <label class="col-12 col-form-label text-info">Course: {{ auth()->user()->courses->name }}</label>
                            <input type="hidden" name="course" value="{{ auth()->user()->courses->id }}" id="course_add">
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-12 col-form-label">Register Subject:</label>
                            <div class="col-12">
                                    <select class="form-control" name="subject" id="subject_add">
                                        @foreach(auth()->user()->subjects as $subject)
                                            <option value="{{ $subject->id}}">{{ $subject->name }}</option>
                                        @endforeach
                                    </select> 
                                    <input type="submit" hidden="hidden" id='submitter' name="Take attendance">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-12 col-form-label">Semester:</label>
                            <div class="col-12">
                                    <select class="form-control" name="semester" id="semester_add">
                                                @for($i=1;$i<=auth()->user()->courses->semester;$i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                    </select> 
                                    <input type="submit" hidden="hidden" id='submitter' name="Take attendance">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-12 col-form-label">Section:</label>
                            <div class="col-12">
                                    <select class="form-control" name="section" id="section_add">
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select> 
                                    <input type="submit" hidden="hidden" id='submitter' name="Take attendance">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary add-register">Create Register</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('js/register.js') }}"></script>
@endsection