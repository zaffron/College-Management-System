@extends('layouts.layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 card bg-dark text-white">
                <div class="card-body">
                    <h4 class="card-title"><span class="fa fa-pencil-square-o"></span> Take Attendance </h4>
                    <hr>
                    <p class="card-text">You can take the attendance of the particular date.</p>
                    <a href="#" class="card-footer text-white bg-primary card-link">Take Attendance <i class="fa fa-pencil" aria-hidden="true"></i></a>
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