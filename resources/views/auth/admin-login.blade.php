<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>College Management System</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Cutive+Mono" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <script defer src="https://use.fontawesome.com/releases/v5.0.4/js/all.js"></script>

</head>
<body>
    <div class="container-fluid main-container">
        <div class="left-part-login">
            <div class="col-md-9 offset-3 left-inside">
                <div class="overlay-inside"></div>
                <div class="upper-part text-right">
                    <i class="fas fa-graduation-cap logo-icon"></i>
                    <h1>CMS</h1>
                    <p>College Management System</p>
                    <hr class="divider-login">
                    <h2>Login | Admin</h2>
                    <p>Welcome to the CMS</p>
                </div>
            </div>
        </div>
        <div class="right-part-login">
            <div class="col-md-9 right-inside">
                <p><strong>Please enter your username and password to login</strong></p>
                @if($errors->has('username')||$errors->has('password'))
                    <div class="alert alert-danger" role="alert">
                        {{ $errors->first('username') }}
                    </div>
                @endif
                <form action="{{ route('admin.login') }}" method="POST" role="form">
                    {{ csrf_field() }}
                    <div class="input-group">
                        <label for="username" class="sr-only">Username</label>
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" name="username" placeholder="Username" class="login-input-box">
                    </div>
                    <div class="input-group">
                        <label for="password" class="sr-only">Password</label>
                        <i class="fas fa-key input-icon"></i>
                        <input type="password" name="password" placeholder="Password" class="login-input-box">
                    </div>
                    <button class="btn btn-login">Login <i class="fas fa-arrow-right"></i> </button>
                </form>
                <a href="{{route('password.request')}}" class="forgot-password-link">Forgot Your Password?</a>
                <a href="{{ route('register') }}" class="forgot-password-link" style="margin-left: 200px;">Register New User !</a>
            </div>
        </div>
    </div>
</body>
</html>
