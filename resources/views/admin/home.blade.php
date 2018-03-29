@extends('layouts.admin')

@section('content')
    {{--Cards to show Notifs--}}
    <div class="row cards-holder">
        <div class="col-xl-3 col-sm-6 mb-4" id="total-student">
            <div class="card text-white bg-primary o-hidden h-10">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fa fa-fw fa-graduation-cap"></i>
                    </div>
                    <div class="mr-5" ><span id="studentCount">{{ count($students) }}</span> Students!</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3" id="total-teacher">
            <div class="card text-white bg-danger o-hidden h-10">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fa fa-fw fa-male"></i>
                    </div>
                    <div class="mr-5">{{ count($users) }} Teachers!</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3" id="total-subjects">
            <div class="card text-white bg-success o-hidden h-10">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fa fa-fw fa-book"></i>
                    </div>
                    <div class="mr-5">{{ count($subjects) }} Subjects!</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3" id="total-class">
            <div class="card text-white bg-warning o-hidden h-10">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fa fa-fw fa-archive"></i>
                    </div>
                    <div class="mr-5">{{ count($departments) }} Departments!</div>
                </div>
            </div>
        </div>
    </div>
    {{--Graph for showing student ratio in every department--}}
    <div class="row">
        <div class="col-lg-12">
            <!-- Example Bar Chart Card-->
            <div class="card mb-3">
                <div class="card-header text-center">
                    <i class="fa fa-bar-chart"></i> Students Counts In Each Department
                </div>
                <div class="card-body">
                    <canvas id="myBarChart" width="100" height="20"></canvas>
                </div>
                <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        var deptNames = [
            @foreach($departments as $department)
                '{{$department->name}}',
            @endforeach
        ];
        var studCounts = [
            @foreach($departments as $department)
                '{{ $department->students_count }}',
            @endforeach
        ];
    </script>
    <script src="{{ asset('js/dashboard-charts.js') }}"></script>
    <script src="{{ asset('js/admin-home.js') }}"></script>
@endsection