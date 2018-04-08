@extends('layouts.layout')

@section('content')
<div class="container">
    {{--Cards to show Notifs--}}
    <div class="row cards-holder">
        <div class="col-xl-3 col-sm-6 mb-3" id="total-student">
            <div class="card text-white bg-primary o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fa fa-fw fa-graduation-cap"></i>
                    </div>
                    <div class="mr-5">{{ count($students) }} Student!</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3" id="total-teacher">
            <div class="card text-white bg-danger o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fa fa-fw fa-male"></i>
                    </div>
                    <div class="mr-5">{{ count($users) }} Teachers!</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3" id="total-subjects">
            <div class="card text-white bg-success o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fa fa-fw fa-book"></i>
                    </div>
                    <div class="mr-5">{{ count($subjects) }} Subjects!</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3" id="total-class">
            <div class="card text-white bg-warning o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fa fa-fw fa-archive"></i>
                    </div>
                    <div class="mr-5">{{ count($courses) }} Total Courses!</div>
                </div>
            </div>
        </div>
    </div>
    {{--Graph for showing student attendance--}}
    <div class="card mb-3">
        <div class="card-header">
            <i class="fa fa-user-o"></i> Attendance Chart
            <div class="col-md-5 pull-right form-inline">
                <label class="form-control-label col-md-2">Subject:</label>
                <select class="form-control col-md-5" id="attendance_subject">
                    @foreach(auth()->user()->subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
                <label class="form-control-label col-md-3">Section:</label>
                <select class="form-control col-md-2" id="section">
                  <option value="A" selected="selected">A</option>
                  <option value="B">B</option>
                  <option value="C">C</option>
                  <option value="D">D</option>
                  <option value="E">E</option>
                </select>
            </div>
        </div>
        <div class="card-body">
            <canvas id="myAttendanceChart" width="100%" height="30"></canvas>
        </div>
        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fa fa-angle-up"></i>
    </a>
@endsection
@section('js')
    <script type="text/javascript">
      var attendance_holder = new Array();
            @foreach($registers as $register)
                attendance_holder["{!! $register->subjects->id !!}{{ $register->section }}attendance"]= {!! $register->total_attendance !!};
                attendance_holder["{!! $register->subjects->id !!}{{ $register->section }}days"] = {!! $register->total_attendance_day !!};
            @endforeach

        // -- Area Chart Example
        var ctx = document.getElementById("myAttendanceChart");
        /*Dynamic loading*/
        var subject_id = "";
        var section = "";
        var labeldata = "";
        var fulldata = "";

        subject_id = $('#attendance_subject').val();
        section = $('#section').val();
        labeldata =  subject_id+section+"days";
        fulldata = subject_id+section+"attendance";
        // Now plotting the chart
        var myLineChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: attendance_holder[labeldata].reverse(),
            datasets: [{
              label: "Students",
              lineTension: 0.3,
              backgroundColor: "rgba(2,117,216,0.2)",
              borderColor: "rgba(2,117,216,1)",
              pointRadius: 5,
              pointBackgroundColor: "rgba(2,117,216,1)",
              pointBorderColor: "rgba(255,255,255,0.8)",
              pointHoverRadius: 5,
              pointHoverBackgroundColor: "rgba(2,117,216,1)",
              pointHitRadius: 20,
              pointBorderWidth: 2,
              data: attendance_holder[fulldata].reverse(),
            }],
          },
          options: {
            scales: {
              xAxes: [{
                time: {
                  unit: 'date'
                },
                gridLines: {
                  display: false
                },
                ticks: {
                  maxTicksLimit: 7
                }
              }],
              yAxes: [{
                ticks: {
                  min: 0,
                  max: 10,
                  maxTicksLimit: 5
                },
                gridLines: {
                  color: "rgba(0, 0, 0, .125)",
                }
              }],
            },
            legend: {
              display: false
            }
          }
        });
        $(document).on('load change','#attendance_subject,#section',function(){
            subject_id = $('#attendance_subject').val();
            section = $('#section').val();
            labeldata =  subject_id+section+"days";
            fulldata = subject_id+section+"attendance";

            subject_id = $('#attendance_subject').val();
            section = $('#section').val();
            labeldata =  subject_id+section+"days";
            fulldata = subject_id+section+"attendance";
            // Now plotting the chart
            var myLineChart = new Chart(ctx, {
              type: 'line',
              data: {
                labels: attendance_holder[labeldata].reverse(),
                datasets: [{
                  label: "Students",
                  lineTension: 0.3,
                  backgroundColor: "rgba(2,117,216,0.2)",
                  borderColor: "rgba(2,117,216,1)",
                  pointRadius: 5,
                  pointBackgroundColor: "rgba(2,117,216,1)",
                  pointBorderColor: "rgba(255,255,255,0.8)",
                  pointHoverRadius: 5,
                  pointHoverBackgroundColor: "rgba(2,117,216,1)",
                  pointHitRadius: 20,
                  pointBorderWidth: 2,
                  data: attendance_holder[fulldata].reverse(),
                }],
              },
              options: {
                scales: {
                  xAxes: [{
                    time: {
                      unit: 'date'
                    },
                    gridLines: {
                      display: false
                    },
                    ticks: {
                      maxTicksLimit: 7
                    }
                  }],
                  yAxes: [{
                    ticks: {
                      min: 0,
                      max: 10,
                      maxTicksLimit: 5
                    },
                    gridLines: {
                      color: "rgba(0, 0, 0, .125)",
                    }
                  }],
                },
                legend: {
                  display: false
                }
              }
            });
        });
        
    </script>
@endsection
