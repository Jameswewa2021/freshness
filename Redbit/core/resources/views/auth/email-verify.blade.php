<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $site_title }} | {{ $page_title }}</title>
    <!--Favicon add-->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logo/icon.png') }}">
    <!--bootstrap Css-->
    <link href="{{ asset('assets/front/css/bootstrap.min.css') }}" rel="stylesheet">
    <!--font-awesome Css-->
    <link href="{{ asset('assets/front/css/font-awesome.min.css') }}" rel="stylesheet">
    <!--Style Css-->
    <link href="{{ asset('assets/front/css/style.css') }}" rel="stylesheet">

    <!-- Mymain css -->
    <!--Responsive Css-->
    <link href="{{ asset('assets/front/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/mymain.css') }}" rel="stylesheet">
    
</head>
<style>
    select:required:invalid {
  color: gray;
}
option[value=""][disabled] {
  display: none;
}
option {
  background-color: #fff !important;
  color: black;
}
input{
  -webkit-user-select: initial !important;
  -khtml-user-select: initial !important;
  -moz-user-select: initial !important;
  -ms-user-select: initial !important;
  user-select: initial !important;
}
</style>

    <div class="bg">
        <div class="container">
            <div class="row">
                <div class="head-login text-left">
                            <a href="{{url('/')}}"><img src="{{asset('assets/images/logo/logo.png')}}" style="max-height:80px;"></a>
                         </div>
                <div class="col-md-12 reg-login text-center">
                    <div class="login-header text-center">
                                    <h4 style="color: #fff !important">Verify Email</h4>
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

                        <form class="form-horizontal" method="POST" action="{{ route('email-verify-submit') }}">
                            {{ csrf_field() }}

                            <h4 class="block">Email Verification Code:</h4>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key fa-2x"></i></span>
                                <input name="code" id="code" class="form-control input-lg" placeholder="Verification Code" type="text" required="">
                            </div>
                            <br>
                            <button class="btn btn-success btn-lg btn-block" type="submit" id="btn-login">Verify Now</button>

                        </form>
                        <form style="margin-top: 10px;" class="form-horizontal" method="POST" action="{{ route('resend-verify-submit') }}">
                            {!! csrf_field() !!}

                            <div class="form-group">
                                <div class="col-md-12 margin-top-10">
                                    <button type="submit" class="btn btn-block btn-danger">
                                        Resend Email for Verification
                                    </button>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
    <!--login section end-->

@endsection
