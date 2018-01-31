@extends('layouts.layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 card bg-dark text-white">
                <div class="card-body">
                    <h4 class="card-title"><span class="fa fa-search-plus"></span> View/Modify Student Details </h4>
                    <hr>
                    <p class="card-text">Search about a student by name, regno or class they take.</p>
                    <a href="#" class="card-footer text-white bg-primary card-link">View/Modify <i class="fa fa-superpowers" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="col-md-6 card bg-dark text-white">
                <div class="card-body">
                    <h4 class="card-title"><span class="fa fa-male"></span> Add Student</h4>
                    <hr>
                    <p class="card-text">Add Student Details.</p>
                    <a href="#" class="card-footer text-white bg-warning card-link" data-toggle="modal" data-target="#addStudent">Add Student <span class="fa fa-address-card-o"></span></a>
                </div>
            </div>
        </div>
        <hr class="bg-primary">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-dark">
                                        <!--Search Form-->
                    <form class="form-inline" action="/action_page.php">
                        <div class="filter-search col-md-3">
                            &nbsp;&nbsp;<span class="fa fa-filter"></span> Filter Search:
                            <select name="" id="">
                                <option value="regno">Regno</option>
                                <option value="name">Name</option>
                                <option value="email">Email</option>
                            </select>
                        </div>
                        <div class="search-message col-md-4">
                            Using <strong>Regno</strong> to search
                        </div>
                        <div class="input-group col-md-5">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i></span>
                            </div>
                            <input type="email" class="form-control" id="email" placeholder="Search..">
                        </div>
                    </form>
                </div>

                <!-- The Modal -->
                <div class="modal fade" id="addStudent">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Add Student</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <form action="" class="form" rold="form">
                                    <div class="form-group">
                                        <label for="name">Full Name</label>
                                        <input type="text" class="form-control" name="fullname">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" name="email">
                                    </div>
                                    <div class="form-group">
                                        <label for="gender">Gender</label>
                                        <select name="" id="" class="form-control" name="gender">
                                            <option value="">Male</option>
                                            <option value="">Female</option>
                                            <option value="">Other</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="course">Course</label>
                                        <select name="" id="" class="form-control">
                                            <option value="">Value 1</option>
                                            <option value="">Value 2</option>
                                        </select>
                                    </div>
                                </form>
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button class="btn btn-primary text-white">Add Student</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th>Regno</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Operation</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>John</td>
                    <td>Doe</td>
                    <td>john@example.com</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-info">Full Details</button>
                        <button type="button" class="btn btn-sm btn-danger">Remove</button>
                    </td>
                </tr>
                <tr>
                    <td>Mary</td>
                    <td>Moe</td>
                    <td>mary@example.com</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-info">Full Details</button>
                        <button type="button" class="btn btn-sm btn-danger">Remove</button>
                    </td>
                </tr>
                <tr>
                    <td>July</td>
                    <td>Dooley</td>
                    <td>july@example.com</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-info">Full Details</button>
                        <button type="button" class="btn btn-sm btn-danger">Remove</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection