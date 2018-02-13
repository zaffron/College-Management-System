@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="col-xl-12 col-sm-12 mb-4" id="total-student">
            <div class="card text-white bg-secondary o-hidden h-10">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fa fa-fw fa-user"></i>
                    </div>
                    <div class="mr-5">Currently there are 26 Proctors!</div>
                </div>
            </div>
        </div>

        <hr class="bg-primary">
        <div class="row">
            <div class="col-md-12 text-center bg-dark text-white">
                <br>
                <h2>Proctees List</h2>
                <br>
                {{--<p>You can make a quick search with the filter available below</p>--}}
            </div>
            {{--<div class="col-md-12">
                <div class="alert alert-default">
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
            </div>--}}
            <table class="table">
                <thead class="bg-warning">
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