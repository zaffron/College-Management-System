@extends('layouts.layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
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
                {{--Search bar finished here--}}

            <table class="table" id="studentTable">
                <thead class="thead-dark">
                <tr>
                    <th>Reg. No.</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Course</th>
                    <th>Full details</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td>{{ $student->regno }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->courses->name }}</td>
                            <td>
                                <button data-toggle="modal" data-target="#showModal" class="btn btn-sm btn-info show-modal" data-id="{{ $student->id }}" data-regno="{{ $student->regno }}" data-name="{{ $student->name }}" data-dob="{{ $student->dob }}" data-email="{{ $student->email }}" data-gender="{{ $student->gender }}" data-contact="{{ $student->contact }}" data-course="{{ $student->courses->name }}" data-proctor="{{ $student->proctors->name }}"><span class="fa fa-eye"></span> Full Details</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>
@endsection

@section('modals')
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
                                        <input type="text" name="course" id="course_show" class="form-control" readonly>
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
                                        <input type="text" class="form-control" name="proctor" id="proctor_show" readonly>
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
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('js/user-student.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/user-search-student.js') }}"></script>
@endsection