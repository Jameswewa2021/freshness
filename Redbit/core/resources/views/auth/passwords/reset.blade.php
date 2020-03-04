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
                    <p class="mb-0">Please enter your email address and new password</p>
                </div>
                @if($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {!!  $error !!}
                    </div>
                @endforeach
                @endif
                @if (session()->has('message'))
                    <div class="alert alert-{{ session()->get('type') }} alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ session()->get('message') }}
                    </div>
                @endif
                @if (session()->has('status'))
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ session()->get('status') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('password.request') }}">
                  {{ csrf_field() }}
                  <input type="hidden" name="token" value="{{ $token }}">
                      <div class="form-group mb-20">
                        <label for="email"><strong>Email Address</strong></label>
                        <div class="input-icon input-icon-right">
                            <input type="text" name="email" id="email" placeholder="Enter your Email" required class="form-control form-control-pill">  
                            <i class="far fa-envelope icon text-fade"></i>
                        </div>
                      </div>
                      <div class="form-group mb-20">
                        <label for="password"><strong>Password</strong></label>
                        <div class="input-icon input-icon-right">
                            <input type="password" name="password" id="password" placeholder="Enter your Password" required class="form-control form-control-pill">  
                            <i class="far fa-lock icon text-fade"></i>
                        </div>
                      </div>
                      <div class="form-group mb-20">
                        <label for="password"><strong>Confirm Password</strong></label>
                        <div class="input-icon input-icon-right">
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" class="form-control form-control-pill">  
                            <i class="far fa-lock icon text-fade"></i>
                        </div>
                      </div>
                    <button type="submit" value="Reset" class="btn btn-primary btn-round btn-block btn-md">Reset Password</button>
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