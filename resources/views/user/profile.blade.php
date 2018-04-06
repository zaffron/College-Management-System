@extends('layouts.layout')

@section('styles')
    <!-- CSFR token for ajax call -->
    <meta name="_token" content="{{ csrf_token() }}"/>

    <!-- toastr notifications -->
    <link rel="stylesheet" href="{{ asset('vendor/toastr/css/toastr.min.css') }}">
    <style type="text/css">
        .profile-img{
            margin-top:50px;
        }
        .uploader{
            margin-top:50px;
            margin-left:45px;
        }
    </style>

@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card p-2 text-center" >
                    <div class="col-md-12">
                        <img class="profile-img" id="avatar-pic" src="{{ (Auth::user()->avatar)? asset('storage/images/profile/'.(Auth::user()->avatar)):asset('img/dummy.png') }}" alt="Card image cap">
                        <div id="uploader" class="uploader">Upload <span class="fa fa-image"></span></div>
                    </div>
                    <div class="card-block">
                        <br>
                        <h4 class="card-title">{{ Auth::user()->username }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <h2>My Profile</h2>
                <hr>
                <form id="profile-form" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <span class="pull-right"> User ID:<strong id="uid">{{ Auth::user()->id }}</strong></span>

                        <input id="avatar-uploader" class="avatar-uploader" hidden="hidden" onchange="readURL(this);" name="avatar" type="file" required>


                        <label for="name">Full Name:</label><br>
                        <input type="text" id="name" name="name" value="{{Auth::user()->name}}" class="form-control"><br>

                        <label for="email">Email:</label><br>
                        <input type="email" id="email" name="email" value="{{ Auth::user()->email}}" class="form-control"><br>

                        <label for="gender">Gender:</label><br>
                        <select name="gender" id="gender" value="{{ Auth::user()->gender}}" class="form-control" id="gender"><br>
                            <option value="m" {!! (Auth::user()->gender == "m")? 'selected="selected"':'' !!}>Male</option>
                            <option value="f" {!! (Auth::user()->gender == "f")? 'selected="selected"':'' !!}>Female</option>
                        </select>
                        <br>
                        <label for="password">Password:</label><span class="text-danger"> Hover over input to see password</span>
                        <input type="password" id="password" name="password" placeholder="password" class="form-control"><br>
                        <button class="btn btn-lg btn-warning update-user">Update</button>

                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')
    {{-- Avatar uploading --}}
    <script type="text/javascript">
        $('#password').mouseover(function(){
            $(this).attr('type', 'text');
        });
        $('#password').mouseout(function(){
            $(this).attr('type','password');
        });
    </script>
{{--     <script src="{{ asset('js/admin-user.js') }}"></script> --}} 
    <script src="{{ asset('js/profile.js') }}"></script>
    {{--For toaster notification--}}
    <script type="text/javascript" src="{{ asset('vendor/toastr/js/toastr.min.js') }}"></script>

@endsection