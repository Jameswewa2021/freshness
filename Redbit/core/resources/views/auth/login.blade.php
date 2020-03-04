<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $site_title }} | {{ $page_title }}</title>

    <!-- favicons -->
    <link rel="icon" type="image/png" href="{{ asset('assets/user1/images/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/user1/images/apple-touch-icon.png') }}">

    <!-- ========================================================= -->
    <!-- All Styles -->
    <!-- ========================================================= -->
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/user1/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!-- font awesome -->
    <link rel="stylesheet" href="{{ asset('assets/user1/vendor/font-awesome/css/font-awesome.min.css') }}">

    <!-- tovvl main style -->
    <link rel="stylesheet" href="{{ asset('assets/user1/css/tovvl.css?v=1.0') }}">
</head>

<body>
    <!-- Page Loader -->
    <div class="page-loader">
        <div class="d-flex a-i-center j-c-center flex-direction-column h-100p">
            <div class="loader-bar">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="loader-text" data-text="BLUE FOREX LIMITED">
                BLUE FOREX LIMITED
            </div>
        </div>
    </div><!-- END / Page Loader -->

    <!-- auth -->
    <div class="auth-boxed">
        <div class="auth-wrapper">
            <div class="auth-content">
                <div class="auth-text">
                    <div class="logo logo-type"><a href="#" style="color:#3498DB">Blue Forex Limited</a></div>
                    <p class="mb-0"><span>Welcome,</span> sign in to continue.</p>
                </div>
                @if($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="px-3 py-2 alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {!!  $error !!}
                    </div>
                @endforeach
                @endif
                
                @if (session()->has('message'))
                    <div class="px-3 py-2 alert alert-{{ session()->get('type') }} alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ session()->get('message') }}
                    </div>
                @endif
                
                @if (session()->has('status'))
                    <div class="px-3 py-2 alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ session()->get('status') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}" >
                    {{ csrf_field() }}
                    <div class="form-group mb-20">
                        <label for="username"><strong>Username</strong></label>
                        <div class="input-icon input-icon-right">
                            <input type="text" name="username" id="username" class="form-control form-control-pill" placeholder="Enter Username" required>  
                            <i class="far fa-user icon text-fade"></i>
                        </div>
                    </div>
                    <div class="form-group mb-20">
                        <label for="password"><strong>Password</strong></label>
                        <div class="input-icon input-icon-right">
                            <input type="password" name="password" id="password" class="form-control form-control-pill" placeholder="Enter your password" required> 
                            <i class="fas fa-lock icon text-fade"></i>
                        </div>
                    </div>
                    <div class="form-group mt-20">
                        <button class="btn btn-primary btn-round btn-block btn-md">Sign In</button>
                    </div>
                    <div class="auth-footer">
                        <hr>
                        <a href="{{ route('password.request') }}">Forgot Password?</a>
                        <p class="mt-5">
                            Do not have an account? <a href="{{url('register')}}">Register</a>
                        </p>
                    </div>             
                    <div class="form-row">
                         @if($basic->google_recap == 1)
                            <div class="form-group col-12">
                                {!! app('captcha')->display() !!}
                            </div>
                        @endif
                    </div>
                    @if($basic->fb_login == '1' || $basic->g_login == '1')
                    <div class="text-center mt-3">Sign In With</div>
                        <div class="form-row">   
                            @if($basic->fb_login == '1')
                            <div class="form-group mb-0 col-6">
                               <a href="{{ url('login/facebook') }}"><button type="button" class="btn btn-facebook shadow-facebook btn-block text-white"><i class="fa fa-facebook-square"></i>Facebook Login</button></a>
                            </div>
                            @endif
                            @if($basic->g_login == '1')
                            <div class="form-group mb-0 col-6 text-right">
                              <a href="{{ url('login/google') }}"><button type="button" class="btn btn-twitter shadow-twitter btn-block text-white"><i class="fa fa-twitter-square"></i> Google Login</button></a>
                            </div>
                            @endif
                        </div>
                    @endif          
                </form>
            </div>
        </div>
    </div>
    <!-- end / auth -->
    
    <!-- ========================================================= -->
    <!-- All Scripts -->
    <!-- ========================================================= -->
    <!-- jquery -->
    <script src="{{ asset('assets/user1/vendor/jquery/js/jquery-3.3.1.min.js') }}"></script>
    <!-- bootstrap -->
    <script src="{{ asset('assets/user1/vendor/popper/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/user1/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- feather icons -->
    <script src="{{ asset('assets/user1/vendor/feather/js/feather.min.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset('assets/user1/js/main.js') }}"></script>
</body>
</html>