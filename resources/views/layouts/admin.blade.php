<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>College Management System</title>
    <!-- Bootstrap core CSS-->
    <link href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="{{asset('vendor/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="{{asset('css/dashboard.css')}}" rel="stylesheet">
    {{-- CSRF --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('styles')
</head>

<body class="fixed-nav sticky-footer bg-light" id="page-top">
@include('admin.partials.navbar')
<div class="content-wrapper">
    <div class="container-fluid">
        @yield('content')
        @yield('modals')
    </div>
</div>


<!-- The modal for notification-->
<div class="modal fade" id="showMessage" tabindex="-1" role="dialog" aria-labelledby="showMessage" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sender"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <p id="message"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap core JavaScript-->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Core plugin JavaScript-->
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
{{--Charts--}}
<script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
<!-- Custom scripts for all pages-->
<script src="{{ asset('js/dashboard.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/common.js') }}"></script>



@yield('js')
</body>

</html>
