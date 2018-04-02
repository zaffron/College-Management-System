@extends('layouts.layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 card bg-dark text-white">
                <div class="card-body">
                    <h4 class="card-title"><span class="fa fa-pencil-square-o"></span> Take Attendance </h4>
                    <hr>
                    <p class="card-text">You can take the attendance of the particular date.</p>
                    <button type="button" data-toggle="modal" data-target="#takeAttendance" class="btn btn-md btn-primary text-white">Take Attendance <i class="fa fa-pencil" aria-hidden="true"></i></button>
                </div>
            </div>
            <div class="col-md-6 card bg-dark text-white">
                <div class="card-body">
                    <h4 class="card-title"><span class="fa fa-line-chart"></span> View Attendance</h4>
                    <hr>
                    <p class="card-text">View Attendance of the particular date or range of dates.</p>
                    <a href="#" class="card-footer text-white bg-warning card-link">View Attendance <span class="fa fa-file-text-o"></span></a>
                </div>
            </div>
        </div>
        <hr class="bg-primary">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger col-md-12">
                    <div class="input-group col-md-8 float-left">
                        <p>Please choose the subject for which you want to view the attendance.</p>
                    </div>
                    <div class="col-md-4 input-group">
                        Subject:&nbsp;
                        <select name="subject" id="subject">
                            <option value="1">Sub 1</option>
                            <option value="2">Sub 2</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <hr class="bg-primary">
        <div class="row">
            {{--Graph for showing student attendance--}}
            <div class="card mb-3 col-md-12">
                <div class="card-header">
                    <i class="fa fa-user-o"></i> Attendance Chart</div>
                <div class="card-body">
                    <canvas id="myAreaChart" width="100%" height="30"></canvas>
                </div>
                <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
            </div>
        </div>
    </div>
@endsection

@section('modals')

    {{--Add modal for adding student--}}
    <div class="modal fade" id="takeAttendance" tabindex="-1" role="dialog" aria-labelledby="takeAttendance" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Subjects:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('attendance.create') }}" method="GET">
                        <div class="form-group row">
                            <label for="name" class="col-12 col-form-label">Subject Name:</label>
                            <div class="col-12">
                                    <select class="form-control" name="subject" id="user-subjects">
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
                                    <select class="form-control" name="semester" id="user-subjects">
                                        @foreach($courses as $course)
                                            @if(auth()->user()->course == $course->id)
                                                @for($i=1;$i<=$course->semester;$i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                                @break
                                            @endif
                                        @endforeach
                                    </select> 
                                    <input type="submit" hidden="hidden" id='submitter' name="Take attendance">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary take-attendance">Take Attendance</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script type="text/javascript">
    $('.take-attendance').on('click',function(){
        $('#submitter').trigger('click');
    });
</script>
@endsection