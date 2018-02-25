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
        <div class="card text-white bg-dark o-hidden h-10">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fa fa-fw fa-building-o"></i>
                </div>
                The number of department is: <strong id="deptCount">{{ count($datas) }}</strong>
                <hr class="bg-white">
                <button type="button" data-toggle="modal" data-target="#addModal" class="btn btn-md btn-primary text-white">Add New Department</button>
            </div>
        </div>
        <br>
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


        <table class="table" id="deptTable">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Department Name</th>
                <th>Description</th>
                <th>Teachers</th>
                <th>Students</th>
                <th>Status</th>
                <th>Operation</th>
            </tr>
            </thead>
            <tbody>

            @forelse($datas as $data)
                <tr class="item{{$data->id}}">
                    <td>{{$data->id}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{App\Department::getExcerpt($data->description)}}</td>
                    <td>{{$data->teachers_count}}</td>
                    <td>{{$data->students_count}}</td>
                    <td>
                        @if($data->active)
                            <span class="text-success">Active</span>
                        @else
                            <span class="text-danger">Inactive</span>
                        @endif
                    </td>
                    {{--                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->updated_at)->diffForHumans() }}</td>--}}
                    <td>
                        <button class="show-modal btn btn-sm btn-success" data-id="{{$data->id}}" data-name="{{$data->name}}" data-description="{{$data->description}}"><span class="fa fa-eye"></span></button>
                        <button class="edit-modal btn btn-sm btn-info" data-id="{{$data->id}}" data-name="{{$data->name}}" data-description="{{$data->description}}"><span class="fa fa-edit"></span></button>
                        @if(!$data->active)
                            <button class="active-modal btn btn-sm btn-warning" data-id="{{$data->id}}" data-name="{{$data->name}}"><span class="fa fa-check"></span></button>
                        @else
                            <button class="delete-modal btn btn-sm btn-danger" data-id="{{$data->id}}" data-name="{{$data->name}}" data-description="{{$data->description}}"><span class="fa fa-trash"></span></button>
                        @endif
                    </td>
                </tr>
            @empty
                <div class="alert alert-dark text-black">No Departments</div>
            @endforelse

            </tbody><!-- table body -->
        </table>
    </div>
@endsection

@section('modals')

    <!-- Modal form to add a department -->
    <div id="addModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Department</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">Title:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name_add" required>
                                {{--<small>Min: 2, Max: 32, only text</small>
                                <p class="errorTitle text-center alert alert-danger hidden"></p>--}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="description">Description:</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" id="description_add" cols="55" rows="5"></textarea>
                                {{--<small>Min: 2, Max: 128, only text</small>
                                <p class="errorContent text-center alert alert-danger hidden"></p>--}}
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success add" data-dismiss="modal">
                            <span id="" class='fa fa-check'></span> Add
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='fa fa-close'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal form to show a department -->
    <div id="showModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="id">ID:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="id_show" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">Title:</label>
                            <div class="col-sm-12">
                                <input type="name" class="form-control" id="name_show" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="description">Description:</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" id="description_show" cols="40" rows="5" disabled></textarea>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='fa fa-remove'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal form to edit a department -->
    <div id="editModal" class="modal fade" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="id">ID:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="id_edit" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">Name:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name_edit" >
                                {{--<p class="errorTitle text-center alert alert-danger hidden"></p>--}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="description">Description:</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" id="description_edit" cols="45" rows="5"></textarea>
                                {{--<p class="errorContent text-center alert alert-danger hidden"></p>--}}
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary edit" data-dismiss="modal">
                            <span class='fa fa-check'></span> Edit
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='fa fa-remove'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal form to delete a department -->
    <div id="deleteModal" class="modal fade" role="dialog">
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
    </div>

    <!-- Modal form to delete a department -->
    <div id="activateModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">Are you sure you want to activate the following department?</h3>
                    <br />
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="id">ID:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="id_activate" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="title">Name:</label>
                            <div class="col-sm-12">
                                <input type="name" class="form-control" id="name_activate" disabled>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success activate" data-dismiss="modal">
                            <span id="" class='fa fa-check'></span> Activate
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='fa fa-remove'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('js')
    {{--For toaster notification--}}
    <script type="text/javascript" src="{{ asset('vendor/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/admin-department.js') }}"></script>
    <script src="{{ asset('js/search-department.js') }}"></script>
@endsection



