@extends('layouts.layout')

@section('content')
    <div class="container">
        <div class="alert alert-success">
            <strong>Hello User!</strong> You have <strong id="procteesNumber">{{ count($proctees) }}</strong> proctee under your list.
        </div>

        <hr class="bg-primary">
        <div class="row">
            <div class="col-md-12 text-center bg-dark text-white">
                <br>
                <h2>Proctees List</h2>
                <br>
            </div>

            <table class="table">
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
                    @foreach($proctees as $proctee)
                        <tr>
                            <td>{{ $proctee->regno }}</td>
                            <td>{{ $proctee->name }}</td>
                            <td>{{ $proctee->email }}</td>
                            <td>{{ $proctee->courses->name }}</td>
                            <td>
                                <button data-toggle="modal" data-target="#showModal" class="btn btn-sm btn-info show-modal" data-id="{{ $proctee->id }}" data-regno="{{ $proctee->regno }}" data-name="{{ $proctee->name }}" data-dob="{{ $proctee->dob }}" data-email="{{ $proctee->email }}" data-gender="{{ $proctee->gender }}" data-contact="{{ $proctee->contact }}" data-course="{{ $proctee->courses->name }}" data-proctor="{{ $proctee->proctors->name }}"><span class="fa fa-eye"></span> Full Details</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
@endsection