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
                @if($errors->has('password') || $errors->has('username'))
                    <div class="alert alert-danger" role="alert">
                        These credentials do not match our records.
                    </div>
                @endif
                <form action="{{ route('admin.submit') }}" method="POST" role="form">
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
                    <div class="input-group">
                        <input type="checkbox" value="remember" name="remember" style="outline:none;width:auto;">
                        <label for="remember" style="margin-top: 7px;margin-left: 5px;">Remember</label>
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
