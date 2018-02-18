<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SB Admin - Start Bootstrap Template</title>
    <!-- Bootstrap core CSS-->
    <link href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="{{asset('vendor/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="{{asset('css/dashboard.css')}}" rel="stylesheet">
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

<!-- Bootstrap core JavaScript-->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Core plugin JavaScript-->
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
{{--Charts--}}
<script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
<!-- Custom scripts for all pages-->
<script src="{{ asset('js/dashboard.min.js') }}"></script>
<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
</script>


@yield('js')
</body>

</html>
