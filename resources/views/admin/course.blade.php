@extends('layouts.admin')


@section('styles')
    <!-- CSFR token for ajax call -->
    <meta name="_token" content="{{ csrf_token() }}"/>

    <!-- toastr notifications -->
    <link rel="stylesheet" href="{{ asset('vendor/toastr/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/selectize/selectize.min.css') }}">
    <style>

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
            <tr class="col-md-12">
                <th class="col-md-1">ID</th>
                <th class="col-md-1">Course Name</th>
                <th class="col-md-4">Description</th>
                <th class="col-md-2">Subjects</th>
                <th class="col-md-1">Semester</th>
                <th class="col-md-2">Operation</th>
            </tr>
            @forelse($courses as $course)
                <tr class='item{{ $course->id }}'>
                    <td class="col-md-1">{{ $course->id}} </td>
                    <td class="col-md-1">{{ $course->name}} </td>
                    <td class="col-md-4">{{ $course->description }}</td>
                    <td class="col-md-2">
                        <select name="show_subjects" id="show_subjects" class="col-md-6">
                                @forelse($course->list as $sub)
                                    <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                                @empty
                                    <option value="#">No Subjects</option>
                                @endforelse
                        </select>
                    </td>
                    <td class="col-md-1">{{ $course->semester }}</td>
                    <td class="col-md-2">
                        <button class='edit-modal btn btn-info btn-sm' data-id="{{ $course->id }}" data-name="{{ $course->name }}" data-subjects="@foreach($course->sub_list as $id){{ $id }},@endforeach" 
                         data-description="{{ $course->description }}" data-semester="{{ $course->semester }}"><span class='fa fa-edit'></span></button>
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
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Course</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" class="form container">
                                <div class="form-group row">
                                    <label for="name" class="col-3 col-form-label">Course Name:</label>
                                    <div class="col-9">
                                        <input class="form-control" name="name" type="text"  id="name_add">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-3 col-form-label">Number of Semester:</label>
                                    <div class="col-9">
                                        <select class="form-control" name="semester" id="semester_add">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label" for="subjects">Subjects:</label>
                                    <select id="input-subjects" class="form-control" multiple="multiple">
                                        @forelse($subjects as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                        @empty
                                            <option disabled="disabled" selected="selected">No subjects</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12 col-form-label" for="description">Description:</label>
                                    <textarea class="form-control" id="description_add" style="resize: none;"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary add">Add Course</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            {{--Add modal for edit course--}}
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Update Course</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" class="form container">
                                <div class="form-group row">
                                    <label for="name" class="col-3 col-form-label">Course Name:</label>
                                    <div class="col-9">
                                        <input class="form-control" name="name" type="text"  id="name_edit">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-3 col-form-label">Number of Semester:</label>
                                    <div class="col-9">
                                        <select class="form-control" name="semester" id="semester_edit">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label" for="subjects">Subjects:</label>
                                    <select id="edit-subjects" class="form-control" multiple="multiple">
                                        @forelse($subjects as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                        @empty
                                            <option disabled="disabled" selected="selected">No subjects</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12 col-form-label" for="description">Description:</label>
                                    <textarea class="form-control" id="description_edit" style="resize: none;"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary edit">Update Course</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
            
            {{--For multiple selection--}}
            <script type="text/javascript" src="{{ asset('vendor/selectize/selectize.min.js') }}"></script>

            {{--For toaster notification--}}
            <script type="text/javascript" src="{{ asset('vendor/toastr/js/toastr.min.js') }}"></script>
            <script type="text/javascript" src="{{ asset('js/admin-course.js') }}"></script>
            <script type="text/javascript">
                $('#input-subjects').selectize({
                    plugins: ['remove_button'],
                    delimiter: ',',
                    persist: false,
                });
            </script>

@endsection