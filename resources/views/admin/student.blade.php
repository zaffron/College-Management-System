@extends('layouts.admin')


@section('styles')
    <!-- CSFR token for ajax call -->
    <meta name="_token" content="{{ csrf_token() }}"/>

    <!-- toastr notifications -->
    <link rel="stylesheet" href="{{ asset('vendor/toastr/css/toastr.min.css') }}">
    <style>
        .panel-heading {
            padding: 0;
        }
        .panel-heading ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        .panel-heading li {
            float: left;
            border-right:1px solid #bbb;
            display: block;
            padding: 14px 16px;
            text-align: center;
        }
        .panel-heading li:last-child:hover {
            background-color: #ccc;
        }
        .panel-heading li:last-child {
            border-right: none;
        }
        .panel-heading li a:hover {
            text-decoration: none;
        }

        .table.table-bordered tbody td {
            vertical-align: baseline;
        }
    </style>
@endsection

@section('content')
    <div class="container">
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
                        <div class="mr-5">92 Subjects!</div>
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
                    <div class="card-header">
                        <i class="fa fa-bar-chart"></i> Students Counts In Each Department
                        <div class="pull-right inline">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addModal">Add Student <span class="fa fa-check-circle"></span></button>
                                <div class="dropdown show ml-3">
                                    <button class="btn btn-sm btn-danger dropdown-toggle" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Import <span class="fa fa-arrow-down"></span>
                                    </button>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="#" id="importXLS" data-toggle="modal" data-target="#xModal">XLS</a>
                                        <a class="dropdown-item" href="#" id="importCSV" data-toggle="modal" data-target="#xModal">CSV</a>
                                    </div>
                                </div>
                                <div class="dropdown show ml-3">
                                    <button class="btn btn-sm btn-success dropdown-toggle" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Export <span class="fa fa-arrow-up"></span>
                                    </button>

                                    <div class="dropdown-menu" id="export-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="#"  onclick="event.preventDefault();document.getElementById('export-xls-form').submit();" >XLS</a>
                                        <a class="dropdown-item" onclick="event.preventDefault();document.getElementById('export-csv-form').submit();" >CSV</a>
                                        <form id="export-xls-form" method="POST" action="{{route('student.export', $type='xls')}}">
                                            {{csrf_field()}}
                                        </form>
                                        <form id="export-csv-form" method="POST" action="{{route('student.export', $type='csv')}}">
                                            {{csrf_field()}}
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="myBarChart" width="100" height="20"></canvas>
                    </div>
                    <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                </div>
            </div>
        </div>
        {{--Search--}}
        <div class="row">
            <form class="form-inline col-md-12">
                <div class="input-group mb-4 col-md-12">
                    <div class="input-group-prepend">
                        <span class="input-group-text fa fa-search bg-white text-warning" id="basic-addon1"></span>
                    </div>
                    <input type="text" autocomplete="off" class="form-control search-box" placeholder="Search..." aria-label="Search" aria-describedby="basic-addon1">
                </div>
            </form>
        </div>
        {{--Table to show the students--}}
        <table class="table" id="studentTable" >
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Reg. No.</th>
                <th>Student Name</th>
                <th>Course</th>
                <th>Operation</th>
            </tr>
            @forelse($students as $student)
                <tr class='item{{ $student->id }}'>
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->regno }}</td>
                    <td>{{ $student->name }}</td>
                    <td>
                        @foreach($courses as $course)
                            @if($course->id == $student->course)
                                {{ $course->name }}
                                @break
                            @endif
                        @endforeach

                    <td>
                        <button class='show-modal btn btn-success btn-sm' data-dob="{{ $student->dob }}" data-regno='{{ $student->regno }}' data-id='{{ $student->id }}' data-gender='{{ $student->gender }}' data-proctor='{{ $student->proctor }}' data-email='{{ $student->email }}' data-contact='{{ $student->contact }}' data-name='{{ $student->name }}' data-course='{{ $student->course }}'><span class='fa fa-eye'></span></button>
                        <button class='edit-modal btn btn-info btn-sm' data-dob="{{ $student->dob }}" data-regno='{{ $student->regno }}' data-id='{{ $student->id }}' data-gender='{{ $student->gender }}' data-proctor='{{ $student->proctor }}' data-email='{{ $student->email }}' data-contact='{{ $student->contact }}' data-name='{{ $student->name }}' data-course='{{ $student->course }}'><span class='fa fa-edit'></span></button>
                        <button class='delete-modal btn btn-danger btn-sm' data-id='{{ $student->id }}' data-regno='{{ $student->regno }}' data-name='{{ $student->name }}' data-course='{{ $course->name }}'><span class='fa fa-trash'></span></button></td>
                </tr>
                @empty
                <tr id="noStudent">
                   <td colspan="5" class="text-center">No Student Found</td>
                </tr>
            @endforelse
            </thead>
            <tbody>

            </tbody><!-- table body -->
        </table>

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fa fa-angle-up"></i>
        </a>
@endsection

@section('modals')
        <!-- Modal -->
            {{--Add modal for adding student--}}
            <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" class="form">
                                <div class="form-group row">
                                    <label for="regno" class="col-2 col-form-label">Regno</label>
                                    <div class="col-10">
                                        <input class="form-control" name="regno" type="text"  id="regno_add">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-2 col-form-label">Name</label>
                                    <div class="col-10">
                                        <input class="form-control" name="name" type="text"  id="name_add">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-2 col-form-label">Email</label>
                                    <div class="col-10">
                                        <input class="form-control" name="email" type="email" id="email_add">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="contact" class="col-2 col-form-label">Contact</label>
                                    <div class="col-10">
                                        <input class="form-control" name="contact" type="tel" id="contact_add">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="dob" class="col-2 col-form-label">DOB</label>
                                    <div class="col-10">
                                        <input class="form-control" name="dob" type="date" value="1995-08-19" id="dob_add">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="course" class="col-3 col-form-label">Course</label>
                                    <div class="col-9">
                                        <select name="course" class="form-control" id="course_add">
                                            @forelse($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                            @empty
                                                No Department
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="gender" class="col-3 col-form-label">Gender</label>
                                    <div class="col-9">
                                        <select name="gender" id="gender_add" class="form-control">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="department-input" class="col-3 col-form-label">Proctor</label>
                                    <div class="col-9">
                                        <select name="proctor" id="proctor_add" class="form-control">
                                            @forelse($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @empty
                                                No Proctor Available
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary add">Add Student</button>
                        </div>
                    </div>
                </div>
            </div>


            {{--Edit model to edit student details--}}
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Student</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" class="form">
                                <div class="form-group row">
                                    <label for="regno" class="col-2 col-form-label">Regno</label>
                                    <div class="col-10">
                                        <input class="form-control" name="regno" type="text"  id="regno_edit">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-2 col-form-label">Name</label>
                                    <div class="col-10">
                                        <input class="form-control" name="name" type="text"  id="name_edit">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-2 col-form-label">Email</label>
                                    <div class="col-10">
                                        <input class="form-control" name="email" type="email" id="email_edit">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="contact" class="col-2 col-form-label">Contact</label>
                                    <div class="col-10">
                                        <input class="form-control" name="contact" type="tel" id="contact_edit">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="dob" class="col-2 col-form-label">DOB</label>
                                    <div class="col-10">
                                        <input class="form-control" name="dob" type="date" id="dob_edit">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="department" class="col-3 col-form-label">Course</label>
                                    <div class="col-9">
                                        <select name="department" class="form-control" id="course_edit">
                                            @forelse($courses as $course)
                                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                                            @empty
                                                No Department
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="gender" class="col-3 col-form-label">Gender</label>
                                    <div class="col-9">
                                        <select name="gender" id="gender_edit" class="form-control">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="department-input" class="col-3 col-form-label">Proctor</label>
                                    <div class="col-9">
                                        <select name="proctor" id="proctor_edit" class="form-control">
                                            @forelse($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @empty
                                                No Proctor Available
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary edit" data-id="">Update Student</button>
                        </div>
                    </div>
                </div>
            </div>
            {{--Show model to show student details--}}
            <div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="showModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Show Student</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" class="form">
                                <div class="form-group row">
                                    <label for="regno" class="col-2 col-form-label">Regno</label>
                                    <div class="col-10">
                                        <input class="form-control" name="regno" type="text"  id="regno_show"  readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-2 col-form-label">Name</label>
                                    <div class="col-10">
                                        <input class="form-control" name="name" type="text"  id="name_show" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-2 col-form-label">Email</label>
                                    <div class="col-10">
                                        <input class="form-control" name="email" type="email" id="email_show" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="contact" class="col-2 col-form-label">Contact</label>
                                    <div class="col-10">
                                        <input class="form-control" name="contact" type="tel" id="contact_show" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="dob" class="col-2 col-form-label">DOB</label>
                                    <div class="col-10">
                                        <input class="form-control" name="dob" type="date" id="dob_show" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="dob" class="col-2 col-form-label">Course</label>
                                    <div class="col-10">
                                        <select name="course" id="course_show" disabled>
                                            @foreach($courses as $course)
                                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="dob" class="col-2 col-form-label">Gender</label>
                                    <div class="col-10">
                                        <input class="form-control" name="gender" type="text" id="gender_show" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="dob" class="col-2 col-form-label">Proctor</label>
                                    <div class="col-10">
                                        <select name="proctor" id="proctor_show" disabled>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal form to delete a department -->
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Delete the following student?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" class="form">
                                <div class="form-group row">
                                    <label for="regno" class="col-2 col-form-label">Regno</label>
                                    <div class="col-10">
                                        <input class="form-control" data-id="" name="regno" type="text"  id="regno_delete"  readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-2 col-form-label">Name</label>
                                    <div class="col-10">
                                        <input class="form-control" name="name" type="text"  id="name_delete" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="course" class="col-2 col-form-label">Course</label>
                                    <div class="col-10">
                                        <input class="form-control" name="course" type="text" id="course_delete" readonly>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger delete">Delete</button>
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            {{--Model for xls and csv import export--}}
            <div class="modal fade" id="xModal" tabindex="-1" role="dialog" aria-labelledby="xModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="xTitle"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" class="form" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label for="file" class="col-2 col-form-label">File</label>
                                    <div class="col-10">
                                        <input class="form-control" name="file" type="file"  id="file_import">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary xConfirm"></button>
                        </div>
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
    {{--For toaster notification--}}
    <script type="text/javascript" src="{{ asset('vendor/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/admin-student.js') }}"></script>
    <script src="{{ asset('js/search-student.js') }}"></script>

@endsection