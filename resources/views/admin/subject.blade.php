@extends('layouts.admin')


@section('styles')
    <!-- CSFR token for ajax call -->
    <meta name="_token" content="{{ csrf_token() }}"/>

    <!-- toastr notifications -->
    <link rel="stylesheet" href="{{ asset('vendor/toastr/css/toastr.min.css') }}">
@endsection

@section('content')
    <div class="container">
        {{--Department count and add--}}
        <div class="card text-black bg-white o-hidden h-10">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fa fa-fw fa-book"></i>
                </div>
                The number of department is: <strong id="subjectCount">{{ count($subjects) }}</strong>
                <hr class="bg-white">
                <button type="button" data-toggle="modal" data-target="#addModal" class="btn btn-md btn-primary text-white">Add New Subject</button>
            </div>
        </div>

        <div class="row" id="app">
            <search></search>
        </div>


        {{--Table to show the students--}}
        <table class="table text-center" id="subjectTable" >
            <thead class="thead-dark">
            <tr>
                <th class="md-1">#</th>
                <th class="md-4">Subject Name</th>
                <th class="md-5">Description</th>
                <th class="md-2">Operation</th>
            </tr>
            @forelse($subjects as $subject)
                <tr class='item{{ $subject->id }}'>
                    <td class="md-1">{{ $subject->id }}</td>
                    <td class="md-9">{{ $subject->name }}</td>
                    <td class="md-5">{{ $subject->description }}</td>
                    <td class="md-2">
                        <button class='edit-modal btn btn-info btn-sm' data-id="{{ $subject->id }}" data-name="{{ $subject->name }}" data-description="{{ $subject->description }}"><span class='fa fa-edit'></span></button>
                        <button class='delete-modal btn btn-danger btn-sm' data-id="{{ $subject->id }}" data-name="{{ $subject->name }}"><span class='fa fa-trash'></span></button>
                    </td>
                </tr>
            @empty
                <tr id="noStudent">
                    <td colspan="5">No Subject Found</td>
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
                            <h5 class="modal-title" id="exampleModalLabel">Add Subject</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" class="form">
                                <div class="form-group row">
                                    <label for="name" class="col-12 col-form-label">Subject Name <span class="text-info"> (Short name if possible):</span></label>
                                    <div class="col-12">
                                        <input class="form-control" name="name" type="text"  id="name_add">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12 col-form-label">Description: </label>
                                    <div class="col-12">
                                        <textarea class="form-control" id="description_add" style="resize: none;"></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary add">Add Subject</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>


            {{--Edit model to edit student details--}}
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Subject</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" class="form">
                                <div class="form-group row">
                                    <label for="name" class="col-12 col-form-label">Subject Name:</label>
                                    <div class="col-12">
                                        <input class="form-control" name="name" type="text"  id="name_edit">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12 col-form-label">Description: </label>
                                    <div class="col-12">
                                        <textarea class="form-control" id="description_edit " style="resize: none;"></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary edit" data-id="">Update Subject</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal form to delete a department -->
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Delete the following subject?</h5>
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
            <script type="text/javascript" src="{{ asset('js/admin-subject.js') }}"></script>
            <script type="text/javascript" src="{{ asset('js/main.js') }}"></script>

@endsection