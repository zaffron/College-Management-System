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
        <div class="col-xl-12 col-sm-12 mb-3 bg-secondary">
            <div class="card text-white bg-info o-hidden h-100">
                <div class="card-body row">
                    <div class="col-md-4 form-inline">
                        Date: {{ $attn_date }}-&nbsp;
                        <select name="attn_day" id="attn_day" class="form-control">
                            @foreach($attn_day as $day)
                                <option value="{{ $day }}">{{ $day }}</option>
                            @endforeach
                        </select>
                        <br> Faculty: {{ auth()->user()->name }}</div>
                    <div class="col-md-4 text-center"><h3>Take Attendance</h3>Subject: {{ $register->subjects->name }}</div>
                    <div class="col-md-4 text-right">Course: {{ $register->courses->name }}<br>Semester: {{ $register->semester }}</div>
                </div>
            </div>
        </div>
        @if($attendance_taken > 0)
            <div class="col-md-12">
                <div class="alert alert-danger text-center">Attendance already taken {{ $attendance_taken }} times for this batch.</div>
            </div>
        @endif
        <form class="form" action="{{ route('attendance.store') }}" method="POST">
            <table class="table table-striped col-md-12 text-center table-dark">
                <tr>
                    <th class="col-md-1">#</th>
                    <th class="col-md-2">Reg. No.</th>
                    <th class="col-md-5">Name</th>
                    <th class="col-md-4">Ateendance</th>
                </tr>
                @foreach($students as $student)
                <tr id="row-{{ $student->regno }}">
                    <td class="col-md-1">{{ $student->id }}</td>
                    <td class="col-md-2">{{ $student->regno }}</td>
                    <td class="col-md-5">{{ $student->name }}</td>
                    <td class="col-md-4">
                        <div class="checkbox-group">
                            <form method="POST" class="attendance-form">
                                <input type="hidden" name="register" value="{{ $register->id }}">
                                <input type="hidden" name="regno" value="{{ $student->regno }}">
                                <input type="hidden" name="std_name" value="{{ $student->name }}">
                                <input type="checkbox" class="attendance-checkbox" checked="checked" name="attendance" id="checkbox-{{ $student->id }}" autocomplete="off" />
                                    <div class="btn-group">
                                        <label for="checkbox-{{ $student->id }}" class="tick btn btn-xs btn-primary">
                                            <span class="fa fa-check"></span>
                                            <span></span>
                                        </label>
                                        <label for="checkbox-{{ $student->id }}" class="status btn btn-xs btn-primary active">
                                        Present
                                       </label>
                                        <button class="btn btn-md h-50 btn-success">
                                        Submit <span class="fa fa-send"></span>
                                       </button>
                                    </div>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </table>
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
    <script type="text/javascript" src="{{ asset('js/attendance.js') }}"></script>
@endsection
