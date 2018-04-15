@extends('layouts.layout')

@section('content')
    <div class="container">
        <div class="alert alert-success">
            <strong>Hello User!</strong> You have <strong id="procteesNumber">{{ count(auth()->user()->proctees) }}</strong> proctee under your list.
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
                    @foreach(Auth::user()->proctees as $proctee)
                        <tr>
                            <td>{{ $proctee->regno }}</td>
                            <td>{{ $proctee->name }}</td>
                            <td>{{ $proctee->email }}</td>
                            <td>
                                @foreach($courses as $course)
                                    @if($course->id == $proctee->course)
                                        {{ $course->name }}
                                        @break
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                <button data-toggle="modal" data-target="#showModal" class="btn btn-sm btn-info show-modal" data-address='{{ $proctee->address }}' data-dob="{{ $proctee->dob }}" data-regno='{{ $proctee->regno }}' data-id='{{ $proctee->id }}' data-gender='{{ $proctee->gender }}' data-proctor='{{ $proctee->proctor }}' data-email='{{ $proctee->email }}' data-contact='{{ $proctee->contact }}' data-semester='{{ $proctee->semester }}' data-avatar='{{ asset("storage/images/proctees/".$proctee->avatar)}}' data-name='{{ $proctee->name }}' data-p_contact = '{{ $proctee->p_contact }}' data-p_email = '{{ ($proctee->p_email)? $proctee->p_email: "No email" }}' data-course='{{ $proctee->course }}' ><span class="fa fa-eye"></span> Full Details</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('modals')
    {{--Show model to show proctee details--}}
            <div class="modal  fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="showModal" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Show proctee</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="#" id="add-proctee-form" method="POST" enctype="multipart/form-data" class="form">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <img class="profile-img" id="avatar-show" src="{{ asset('img/dummy.png') }}" alt="Card image cap">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group row">
                                            <label for="regno" class="col-2 col-form-label">Regno</label>
                                            <div class="col-10">
                                                <input class="form-control" disabled="disabled" name="regno" type="text"  id="regno_show">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="name" class="col-2 col-form-label">Name</label>
                                            <div class="col-10">
                                                <input class="form-control" disabled="disabled" name="name" type="text"  id="name_show">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email" class="col-2 col-form-label">Email</label>
                                            <div class="col-10">
                                                <input class="form-control" name="email" type="email" id="email_show">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="gender" class="col-2 col-form-label">Gender</label>
                                            <div class="col-4">
                                                <select name="gender" disabled="disabled" id="gender_show" class="form-control">
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                </select>
                                            </div>
                                            <label for="dob" class="col-1 col-form-label">DOB</label>
                                            <div class="col-5">
                                                <input class="form-control" disabled="disabled" name="dob" type="date" id="dob_show">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="contact" class="col-2 col-form-label">Contact</label>
                                            <div class="col-10">
                                                <input class="form-control" name="contact" type="tel" id="contact_show">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                    <div class="form-group row">
                                    <label for="course" class="col-1 col-form-label">Course</label>
                                    <div class="col-3">
                                        <select name="course" class="form-control" disabled="disabled" id="course_show">
                                            @forelse($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                            @empty
                                                No Department
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group row">
                                        <label for="sem" class="col-md-4 col-form-label">Sem: </label>
                                        <div class="col-md-8">
                                            <select name="semester" class="form-control" disabled="disabled" id="semester_show">
                                                @for($i=1;$i<=10;$i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>                                            
                                        </div>
                                    </div>
                                    <label for="department-input" class="col-1 col-form-label">Proctor</label>
                                    <div class="col-5">
                                        <select name="proctor" id="proctor_show" disabled="disabled" class="form-control">
                                            @forelse($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @empty
                                                No Proctor Available
                                            @endforelse
                                        </select>
                                    </div>
                                    
                                </div>
                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Parent No.</label>
                                    <input class="form-control col-md-4" type="tel" name="p_contact" id="parent_contact_show">

                                    <label class="col-2 col-form-label">Parent Email</label>
                                    <input class="form-control col-md-3" id="parent_email_show" type="email" name="p_email" >
                                </div>
                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Address</label>
                                    <textarea class="form-control col-md-9" id="address_show" style="resize:none;" name="address" rows="2"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary update-proctee">Update proctee</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
@endsection
@section('js')
    <script type="text/javascript" src="{{ asset('js/user-student.js') }}"></script>
@endsection