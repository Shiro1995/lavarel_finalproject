<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ezhealthcare</title>
    <link rel="icon" href="{{ URL::asset('images/favicon.ico') }}" type="image/ico"/>
    <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/custom.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/login.min.css') }}" rel="stylesheet">
</head>

<body>
<div class="container" id="container">
    <div class="form-container sign-up-container">
        <form method="post" action="{{ route('register') }}">
            <h1>Create Account</h1>
            <div class="social-container">
                <a href="#" class="social"><i class="fa fa-facebook-f"></i></a>
                <a href="#" class="social"><i class="fa fa-google"></i></a>
                <a href="#" class="social"><i class="fa fa-linkedin"></i></a>
            </div>
            <span>or use your email for registration</span>
            <input type="text" name="name" placeholder="Name" />
            <input type="email" name="email" placeholder="Email" />
            <input type="password" name="password" placeholder="Password" />
            <input type="password" name="password_confirmation" placeholder="Password Confirmation" />
            <input type="submit" value="Sign Up"/>
        </form>
    </div>
    <div class="form-container sign-in-container">
        <form method="post" action="{{ route('login') }}">
            <h1>Ezhealthcare</h1>
            <div class="social-container">
                <a href="#" class="social"><i class="fa fa-facebook-f"></i></a>
                <a href="#" class="social"><i class="fa fa-google"></i></a>
                <a href="#" class="social"><i class="fa fa-linkedin"></i></a>
            </div>
            <span>or use your account</span>
            <input type="email" name="email" placeholder="Email" />
            @if ($errors->has('email'))
                <span class="help-block error">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
            <input type="password" name="password" placeholder="Password" />
            @if ($errors->has('password'))
                <span class="help-block error">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
            <a href="#">Forgot your password?</a>
            <input type="submit" value="Sign In"/>
        </form>
    </div>
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h1>Welcome Back!</h1>
                <p>To keep connected with us please log in with your personal info</p>
                <button class="ghost" id="signIn">Sign In</button>
            </div>
            <div class="overlay-panel overlay-right">
                <h1>Hello, Hello, Ezhealthcare here!</h1>
                <p>Enter your personal details and start the journey with us</p>
                <button class="ghost" id="signUp">Sign Up</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ URL::asset('js/login.min.js') }}"></script>
</body>
</html>
