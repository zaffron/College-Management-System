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
        {{--Department count and add--}}
        <div class="card text-black bg-white o-hidden h-10">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fa fa-fw fa-book"></i>
                </div>
                The number of course is: <strong id="courseCount">{{ count($courses) }}</strong>
                <hr class="bg-white">
                <button type="button" data-toggle="modal" data-target="#addModal" class="btn btn-md btn-primary text-white">Add New Course</button>
            </div>
        </div>

        {{--Table to show the students--}}
        <table class="table text-center" id="courseTable" >
            <thead class="thead">
            <tr>
                <th class="col-md-1">#</th>
                <th class="col-md-9">Course Name</th>
                <th class="col-md-2">Operation</th>
            </tr>
            @forelse($courses as $course)
                <tr class='item{{ $course->id }}'>
                    <td>{{ $course->id }}</td>
                    <td>{{ $course->name }}</td>
                    <td>
                        <button class='edit-modal btn btn-info btn-sm' data-id="{{ $course->id }}" data-name="{{ $course->name }}"><span class='fa fa-edit'></span></button>
                        <button class='delete-modal btn btn-danger btn-sm' data-id="{{ $course->id }}" data-name="{{ $course->name }}"><span class='fa fa-trash'></span></button>
                    </td>
                </tr>
            @empty
                <tr id="noStudent">
                    <td colspan="3" >No Course Found</td>
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
                            <h5 class="modal-title" id="exampleModalLabel">Add Course</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" class="form">
                                <div class="form-group row">
                                    <label for="name" class="col-12 col-form-label">Course Name:</label>
                                    <div class="col-12">
                                        <input class="form-control" name="name" type="text"  id="name_add">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary add">Add Course</button>
                        </div>
                    </div>
                </div>
            </div>


            {{--Edit model to edit student details--}}
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Course</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" class="form">
                                <div class="form-group row">
                                    <label for="name" class="col-12 col-form-label">Course Name:</label>
                                    <div class="col-12">
                                        <input class="form-control" name="name" type="text"  id="name_edit">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary edit" data-id="">Update Course</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal form to delete a department -->
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Delete the following course?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" class="form">
                                <div class="form-group row">
                                    <label for="regno" class="col-12 col-form-label">ID</label>
                                    <div class="col-12">
                                        <input class="form-control" name="regno" type="text"  id="id_delete"  readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-12 col-form-label">Name</label>
                                    <div class="col-12">
                                        <input class="form-control" name="name" type="text"  id="name_delete" readonly>
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
        @endsection

        @section('js')

            {{--For toaster notification--}}
            <script type="text/javascript" src="{{ asset('vendor/toastr/js/toastr.min.js') }}"></script>
            <script type="text/javascript" src="{{ asset('js/admin-course.js') }}"></script>

@endsection