@extends('layouts.admin')

@section('styles')
    <!-- CSFR token for ajax call -->
    <meta name="_token" content="{{ csrf_token() }}"/>

    <!-- toastr notifications -->
    <link rel="stylesheet" href="{{ asset('vendor/toastr/css/toastr.min.css') }}">
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card p-2 text-center" >
                    <div class="col-md-12">
                        <img class="profile-img" src="{{ asset('img/dummy.png') }}" alt="Card image cap">
                        <div id="uploader">Upload <span class="fa fa-image"></span></div>
                        <input id="avatar-uploader" name="avatar" type="file" required>
                    </div>
                    <div class="card-block">
                        <h4 class="card-title">Username</h4>
                        <p class="card-text">Some cool description</p>
                        <a href="#" class="btn btn-primary">Update Description</a>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <h1>My Profile</h1>
                <hr>
                <form action="#">
                        <label for="name">Full Name:</label><br>
                        <input type="text" name="name" class="form-control"><br>

                        <label for="email">Email:</label><br>
                        <input type="email" name="email" class="form-control"><br>

                        <label for="gender">Gender:</label><br>
                        <select name="gender" class="form-control" id="gender"><br>
                            <option value="m">Male</option>
                            <option value="f">Female</option>
                        </select><br><br>

                        <label for="password">Password:</label><br>
                        <input type="password" name="password" class="form-control"><br>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')
    {{--For toaster notification--}}
    <script type="text/javascript" src="{{ asset('vendor/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/admin-user.js') }}"></script>
    <script src="{{ asset('js/profile.js') }}"></script>
@endsection