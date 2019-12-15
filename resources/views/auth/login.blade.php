<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    <link rel="icon" href="{{ URL::asset('images/favicon.ico') }}" type="image/ico"/>
    <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/animate.min.css') }}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ URL::asset('css/custom.min.css') }}" rel="stylesheet">
    <!-- Custom Your Style -->
    <link href="{{ URL::asset('css/login.min.css') }}" rel="stylesheet">
</head>

<body>
    <div class="main-bg">
        <div class="box-conatiner">
            <div id="a">
                <div class="circle-ripple"></div>
            </div>

            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <h1 class="heading-left">For Continue Please Login</h1>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="wrap-login100">
                    <span class="login100-form-title">
                        Sign In
                    </span>
                        <form class="login100-form validate-form p-l-55 p-r-55 p-t-20">

                            <div class="wrap-input100 validate-input m-b-16" data-validate="Please enter username">
                                <input class="input100" type="text" name="username" placeholder="Username">
                                <span class="focus-input100"></span>
                            </div>
                            <div class="wrap-input100 validate-input" data-validate="Please enter password">
                                <input class="input100" type="password" name="pass" placeholder="Password">
                                <span class="focus-input100"></span>
                            </div>
                            <div class="text-right p-t-13 p-b-23">
                            <span class="txt1">
                                Forgot
                            </span>
                                <a href="#" class="txt2">
                                    Username / Password?
                                </a>
                            </div>
                            <div class="container-login100-form-btn">
                                <button class="login100-form-btn">
                                    Sign in
                                </button>
                            </div>
                            <div class="flex-col-c p-t-140 p-b-40">
                            <span class="txt1 p-b-9">
                                Don’t have an account?
                            </span>
                                <a href="#" class="txt3">
                                    Sign up now
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
