@extends('layouts.layout')

@section('styles')
    <style type="text/css">
        .checkbox-group input[type="checkbox"] {
            display: none;
        }

        .checkbox-group input[type="checkbox"] + .btn-group > label span {
            width: 20px;
        }

        .checkbox-group input[type="checkbox"] + .btn-group > label span:first-child {
            display: inline-block;
        }
        .checkbox-group input[type="checkbox"] + .btn-group > label span:last-child {
            display: inline-block;   
        }

        .checkbox-group input[type="checkbox"]:checked + .btn-group > label span:first-child {
            display: inline-block;
        }
        .checkbox-group input[type="checkbox"]:checked + .btn-group > label span:last-child {
            display: inline-block;   
        }

        /*Marquee*/


    </style>
@endsection

@section('content')
    <div class="container">
        <div class="col-xl-12 col-sm-12 mb-3">
            <div class="card text-white bg-info o-hidden h-100">
                <div class="card-body row">
                    <div class="col-md-4">Date: {{ $attn_date }}<br> Faculty: {{ auth()->user()->name }}</div>
                    <div class="col-md-4 text-center"><h3>Take Attendance</h3>Subject: {{ $subject->name }}</div>
                    <div class="col-md-4 text-right">Course: {{ $course->name }}<br>Semester: {{ $semester }}</div>
                </div>
            </div>
        </div>
        <form class="form" action="{{ route('attendance.store') }}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="course" value="{{ $course }}">
            <input type="hidden" name="semester" value="{{ $semester }}">
            <input type="hidden" name="subject" value="{{ $subject }}">
            <input type="hidden" name="students" value="{{ $students }}">
            <input type="hidden" name="attn_date" value="{{ $attn_date }}">
            <input type="hidden" name="ver_date" value="{{ $ver_date }}">
            <table class="table table-striped col-md-12 text-center table-dark">
                <tr>
                    <th>Reg. No.</th>
                    <th>Name</th>
                    <th>Ateendance</th>
                </tr>
                @foreach($students as $student)
                <tr>
                    <td>{{ $student->regno }}</td>
                    <td>{{ $student->name }}</td>
                    <td>
                        <div class="checkbox-group">
                            <input type="checkbox" class="attendance-checkbox" checked="checked" name="{{ $student->id }}" id="checkbox-{{ $student->id }}" autocomplete="off" />
                                <div class="btn-group">
                                    <label for="checkbox-{{ $student->id }}" class="tick btn btn-xs btn-primary">
                                        <span class="fa fa-check"></span>
                                        <span></span>
                                    </label>
                                    <label for="checkbox-{{ $student->id }}" class="status btn btn-xs btn-primary active">
                                    Present
                                   </label>
                                </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </table>
            <div class="form-input-group text-center">
                <marquee class="text-danger" behavior="alternate">Once the attendance is taken it can't be reverted !</marquee><br><br>
                <button class="btn btn-success">Submit Attendance</button>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $('.attendance-checkbox').change(function(){
            var input = '#' + $(this).attr('id');
            $(input).next().children('.tick').children('.fa').toggleClass('fa-check fa-close');
            $(input).next().children('.tick').toggleClass('btn-primary btn-danger');
            if($(this).is(":checked")){
                $(input).next().children('.status').toggleClass('btn-primary btn-danger');
                $(input).next().children('.status').text('Present');
            }else{
                $(input).next().children('.status').toggleClass('btn-primary btn-danger');
                $(input).next().children('.status').text('Absent');
            }
        });
    </script>
@endsection
