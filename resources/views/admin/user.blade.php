@extends('layouts.admin')

@section('styles')
    <!-- CSFR token for ajax call -->
    <meta name="_token" content="{{ csrf_token() }}"/>

    <!-- toastr notifications -->
    <link rel="stylesheet" href="{{ asset('vendor/toastr/css/toastr.min.css') }}">
@endsection

@section('content')
    <div class="container">
        {{--Cards to show Notifs--}}
        <div class="row cards-holder">
            <div class="col-xl-6 col-sm-6 mb-3" id="total-teacher">
                <div class="card text-white bg-danger o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fa fa-fw fa-user-o"></i>
                        </div>
                        <div class="mr-5">The total number of users is: <strong id="userCount">{{ count($users) }}</strong> </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-sm-6 mb-3" id="total-teacher">
                <div class="card text-white bg-success o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fa fa-fw fa-user-secret"></i>
                        </div>
                        <div class="mr-5">The total number of admins is: <strong id="adminCount">{{ count($admins) }}</strong> </div>
                    </div>
                </div>
            </div>
        </div>
        {{--Graph for showing student attendance--}}
        <div class="row">
            <div class="col-lg-8">
                <div class="card text-white bg-dark o-hidden h-10 col-md-12">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fa fa-fw fa-search"></i>
                        </div>
                        <div class="mr-5">Quick User View</div>
                    </div>
                </div>
                <table class="table" id="adminsTable">
                    <thead class="thead-dark">
                    <tr>
                        <th class="text-center text-dark bg-warning" colspan="4">Admins</th>
                    </tr>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Operation</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($admins as $admin)
                        <tr class="adminItem{{$admin->id}}">
                            <td>{{ $admin->id }}</td>
                            <td>{{ $admin->username }}</td>
                            <td>{{ $admin->email }}</td>
                            <td class="col-md-1">
                                <button class="show-modal btn btn-sm btn-success" data-admin="admin" data-id="{{$admin->id}}" data-email="{{ $admin->email }}" data-gender="{{ $admin->gender }}" data-name="{{$admin->name}}" data-username="{{$admin->username}}"><span class="fa fa-eye"></span></button>
                                <button class="delete-modal btn btn-sm btn-danger" data-id="{{$admin->id}}" data-email="{{ $admin->email }}" data-gender="{{ $admin->gender }}" data-name="{{$admin->name}}"  data-username="{{$admin->username}}"><span class="fa fa-trash"></span></button>
                            </td>
                        </tr>
                    @endforeach

                    </tbody><!-- table body -->
                </table>
                <table class="table" id="usersTable">
                    <thead class="thead-dark">
                    <tr>
                        <th class="text-center text-dark bg-warning" colspan="4">Teachers</th>
                    </tr>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Operation</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($users as $user)
                        <tr class="userItem{{$user->id}}">
                            <td>{{$user->id}}</td>
                            <td>{{$user->username}}</td>
                            <td>{{$user->email }}</td>
                            <td class="col-md-1">
                                <button class="show-modal btn btn-sm btn-success" data-admin="user" data-department="{{$user->department}}" data-id="{{$user->id}}" data-email="{{ $user->email }}" data-gender="{{ $user->gender }}" data-name="{{$user->name}}" data-username="{{$user->username}}"><span class="fa fa-eye"></span></button>
                                <button class="delete-modal btn btn-sm btn-danger" data-id="{{$user->id}}" data-email="{{ $user->email }}" data-gender="{{ $user->gender }}" data-name="{{$user->name}}" data-username="{{$user->username}}"><span class="fa fa-trash"></span></button>
                            </td>
                        </tr>
                    @empty
                        <div class="alert alert-dark text-black">No Users</div>
                    @endforelse
                    </tbody><!-- table body -->
                </table>
            </div>


            <div class="col-lg-4">
                <div class="card mb-3">
                    <div class="card-header text-center">
                        Operations
                    </div>
                    <div class="card-body">
                        <div class="col-md-12 text-center">
                            <button type="button" data-toggle="modal" data-admin="User" data-target="#addUserModal" class="add-modal btn col-md-5 btn-md btn-primary text-white">Add User</button>
                            <button type="button" data-toggle="modal" data-admin="Admin" data-target="#addUserModal" class="add-modal btn btn-md col-md-5 btn-primary text-white">Add Admin</button>
                        </div>
                    </div>
                </div>
                <!--Pie Chart Card-->
                <div class="card mb-3">
                    <div class="card-header text-center">
                        <i class="fa fa-pie-chart"></i> User Chart </div>
                    <div class="card-body">
                        <canvas id="myPieChart" width="100%" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>


        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fa fa-angle-up"></i>
        </a>
    </div>
@endsection

@section('modals')

    {{--All modals--}}
    <!-- Modal form to add a user -->
    <div id="addUserModal" class="modal fade" role="dialog" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title modal-name"></h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label for="username" class="control-label col-sm-2">Username:</label>
                            <input type="text" class="form-control" id="username_add" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">Name:</label>
                            <input type="text" class="form-control" id="name_add"  required>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">Email:</label>
                            <input type="email" class="form-control" id="email_add"  required>
                        </div>
                        <div class="form-group dept-row">
                            <label for="department" class="control-label col-sm-2">Department</label>
                            <select name="department" id="department_add" class="form-control">
                                @forelse($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @empty
                                    <opton>No department</opton>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label col-sm-2">Password:</label>
                            <input type="password" class="form-control" id="password_add"  required>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-6" for="confirm_password">Confirm Password:</label>
                            <input type="password" class="form-control" id="confirm_password_add"  required>
                        </div>
                        <div class="form-group">
                            <label for="gender" class="control-label col-sm-2">Gender:</label>
                            <select name="gender" id="gender_add" class="form-control">
                                <option value="male" selected>Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success add-user" data-dismiss="modal">
                            <span class='fa fa-check'></span> Add
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='fa fa-close'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal form to show a user/admin -->
    <div id="showModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title modal-name"></h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label for="id" class="control-label col-sm-2">ID:</label>
                            <input type="text" class="form-control" id="id_show" readonly>
                        </div>
                        <div class="form-group">
                            <label for="username" class="control-label col-sm-2">Username:</label>
                            <input type="text" class="form-control" id="username_show" readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">Name:</label>
                            <input type="text" class="form-control" id="name_show"  readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="email">Email:</label>
                            <input type="email" class="form-control" id="email_show"  readonly>
                        </div>
                        <div class="form-group dept-row">
                            <label for="department" class="control-label col-sm-2">Department:</label>
                            <input type="text" class="form-control" id="department_show">
                        </div>
                        <div class="form-group">
                            <label for="gender" class="control-label col-sm-2">Gender:</label>
                            <input type="text" class="form-control" id="gender_show">
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='fa fa-close'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal form to delete a user -->
    <div id="deleteModal" class="modal fade" role="dialog" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">Are you sure you want to delete the following department?</h3>
                    <br />
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="id">ID:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="id_delete" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="title">Name:</label>
                            <div class="col-sm-12">
                                <input type="name" class="form-control" id="name_delete" disabled>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger delete" data-dismiss="modal">
                            <span id="" class='fa fa-trash'></span> Delete
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='fa fa-remove'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>{{--Modals ends here--}}
@endsection

@section('js')
    <script>
        var departmentNames = [
            @foreach($departments as $department)
            " {{ $department->name }} ",
            @endforeach
        ];
        var dataValues = [
            @foreach($departments as $department)
            " {{ $department->teachers_count }} ",
            @endforeach
        ];
    </script>
            {{--For toaster notification--}}
            <script type="text/javascript" src="{{ asset('vendor/toastr/js/toastr.min.js') }}"></script>
            <script src="{{ asset('js/admin-user.js') }}"></script>
@endsection