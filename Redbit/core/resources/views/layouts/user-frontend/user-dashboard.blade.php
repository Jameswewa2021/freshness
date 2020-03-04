<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $site_title }} | {{ $page_title }}</title>

    <!-- favicons -->
    <link rel="icon" type="image/png" href="{{asset('assets/user1/images/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{asset('assets/user1/images/apple-touch-icon.png') }}">

    <!-- =========================================================-->
    <!-- All Styles -->
    <!-- ========================================================= -->
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{asset('assets/user1/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!-- font awesome -->
    <link rel="stylesheet" href="{{asset('assets/user1/vendor/font-awesome/css/font-awesome.min.css') }}">
    <!-- perfect scrollbar -->
    <link rel="stylesheet" href="{{asset('assets/user1/vendor/perfect-scrollbar/css/perfect-scrollbar.min.css') }}">

    <!-- crypto coins icon -->
    <link rel="stylesheet" href="{{asset('assets/user1/vendor/cryptocoins/css/cryptocoins.css') }}">
    <link rel="stylesheet" href="{{asset('assets/user1/vendor/cryptocoins/css/cryptocoins-colors.css') }}">
    <!-- select2 -->
    <link rel="stylesheet" href="{{asset('assets/user1/vendor/select2/css/select2.min.css') }}">
    <!-- boostrap datepicker-->
    <link rel="stylesheet" href="{{asset('assets/user1/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
    <!-- data table -->
    <link rel="stylesheet" href="{{asset('assets/user1/vendor/datatables/css/jquery.dataTables.min.css') }}">
    <!-- tovvl main style -->
    <link rel="stylesheet" href="{{asset('assets/user1/css/tovvl.css') }}">
    <link rel="stylesheet" href="{{asset('assets/user1/css/mycustom.css') }}">
</head>
@yield('style')
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
    <div class="wrapper">            
        <!-- Mobile Menu -->
        <div class="mobile-menu">
            <!-- mobil menu header -->
            <div class="mm-header">
                <div class="mm-logo">
                    <div class="logo logo-type logo-white">
                        <a href="{{url('/')}}" class="text-white">BLUE FOREX LIMITED</a>
                    </div>
                </div>

                <div class="mm-buttons">
                    <a href="#" class="mm-trigger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </a>
                </div>
            </div> <!-- END / mobil menu header -->

            <!-- mobile menu body -->
            <div class="mm-body">
                <ul class="nav">
                    <li class="nav-item {{ Request::path() == 'backoffice/dashboard' ? 'active' : '' }}">
                        <a href="{!! route('user-dashboard') !!}" class="nav-link">
                            <span class="feather-icon"><i data-feather="activity"></i></span><span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item sub-item {{ Request::path() == 'backoffice/binaryd' ? 'active' : '' }} {{ Request::path() == 'backoffice/network' ? 'active' : '' }} {{ Request::path() == 'backoffice/network-show' ? 'active' : '' }} {{ Request::path() == 'backoffice/referrals' ? 'active' : '' }}">
                        <a href="#" class="nav-link sub-item-toggle">
                            <span class="feather-icon"><i data-feather="layout"></i></span><span>Network</span>
                        </a>
                        <div class="sub-menu">
                            <ul>
                                <li><a href="{!! route('network') !!}">Binary Tree</a></li>
                                <li><a href="{!! route('binaryd') !!}">Business</a></li>
                                <li><a href="{!! route('referrals') !!}">Direct Referral</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item sub-item {{ Request::path() == 'backoffice/plan' ? 'active' : '' }} {{ Request::path() == 'backoffice/package' ? 'active' : '' }}">
                        <a href="#" class="nav-link sub-item-toggle">
                            <span class="feather-icon"><i data-feather="file-text"></i></span><span>Packages</span>
                        </a>
                        <div class="sub-menu">
                            <ul>
                                <li><a href="{!! route('plan.all') !!}">Buy</a></li>
                                <li><a href="{!! route('package') !!}">Purchased</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item {{ Request::path() == 'backoffice/income' ? 'active' : '' }}">
                        <a href="{!! route('roi') !!}" class="nav-link">
                            <span class="feather-icon"><i data-feather="edit"></i></span><span>Earnings</span>
                        </a>
                    </li>
                    <li class="nav-item sub-item {{ Request::path() == 'backoffice/withdraw-BTC' ? 'active' : '' }} {{ Request::path() == 'backoffice/withdraw-log' ? 'active' : '' }} {{ Request::path() == 'backoffice/deposit-history' ? 'active' : '' }}">
                        <a href="#" class="nav-link sub-item-toggle">
                            <span class="feather-icon"><i data-feather="menu"></i></span><span>Financials</span>
                        </a>
                        <div class="sub-menu">
                            <ul>
                                <li><a href="{!! route('withdraw-request-bitcoin') !!}">Withdraw</a></li>
                                <li><a href="{!! route('withdraw-log') !!}">Withdraw Logs</a></li>
                                <li><a href="{!! route('deposit-history') !!}">Deposit Logs</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item sub-item {{ Request::path() == 'backoffice/document' ? 'active' : '' }}">
                        <a href="#" class="nav-link sub-item-toggle">
                            <span class="feather-icon"><i data-feather="package"></i></span><span>Media</span>
                        </a>
                        <div class="sub-menu">
                            <ul>
                                <li><a href="{!! route('document') !!}">Presentation</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item {{ Request::path() == 'backoffice/support-all' ? 'active' : '' }}">
                        <a href="{!! route('support-all') !!}" class="nav-link">
                            <span class="feather-icon"><i data-feather="layers"></i></span><span>Support</span>
                        </a>
                    </li>
                </ul>
            </div><!-- END / mobile menu body -->
        </div><!-- END / Mobile Menu -->

        <!-- Header -->
        <header >
            <div class="header py-10" style="background-color: #3a3a3a !important;margin-top: 0 !important;">
                <div class="container">
                    <!-- header left -->
                    <div class="header-left hide-md">
                        <div class="header-logo logo-type">
                            <a href="{{url('/')}}" class="text-white">BLUE FOREX LIMITED</a>
                        </div>
                    </div><!-- END / header left -->

                    <!-- header right -->
                    <div class="header-right">              
                        <!-- dropdown profile -->
                        <div class="dropdown header-profile">
                            <a href="#" data-toggle="dropdown" class="avatar avatar-sm dropdown-toggle">
                                <img src="{{ asset('assets/images') }}/{{ Auth::user()->image }}" class="img-responsive" alt="...">
                            </a>    
                            <div class="dropdown-menu dropdown-menu-right">
                                @if(Auth::check())
                                <div class="header-profile-info">
                                    <div class="user-img">
                                        <img src="{{ asset('assets/images') }}/{{ Auth::user()->image }}" class="img-responsive" alt="...">
                                    </div>
                                    <div class="user-name">{{Auth::user()->name}}</div>
                                </div>
                                <div class="header-profile-menu">
                                    <a href="{!! route('account') !!}" class="dropdown-item">
                                        <span class="feather-icon"><i data-feather="user"></i></span>
                                        My Profile
                                    </a>
                                    <a href="{{ route('go2fa') }}" class="dropdown-item">
                                        <span class="feather-icon"><i data-feather="settings"></i></span>
                                        2FA
                                    </a>
                                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        <span class="feather-icon"><i data-feather="power"></i></span>
                                        Sign Out
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                    </form>
                                </div>
                                @else
                                    <div class="header-profile-menu">
                                        <a href="{{ route('login') }}" class="dropdown-item">
                                            <span class="feather-icon"><i data-feather="user"></i></span>
                                            Login
                                        </a>
                                        <a href="{{ route('register') }}" class="dropdown-item">
                                            <span class="feather-icon"><i data-feather="settings"></i></span>
                                            Register
                                        </a>
                                    </div>
                                @endif 
                            </div>
                        </div><!-- END / dropdown profile -->
                    </div><!-- END / header right -->
                </div>
            </div>
            <!-- Main Menu -->
            <div class="main-menu color-scheme-mix">
                <div class="container">
                    <ul class="nav">
                        <li class="nav-item {{ Request::path() == 'backoffice/dashboard' ? 'active' : '' }}">
                            <a href="{!! route('user-dashboard') !!}" class="nav-link">
                                <span class="feather-icon"><i data-feather="activity"></i></span><span>Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item sub-item {{ Request::path() == 'backoffice/referrals' ? 'active' : '' }} {{ Request::path() == 'backoffice/binaryd' ? 'active' : '' }} {{ Request::path() == 'backoffice/network' ? 'active' : '' }} {{ Request::path() == 'backoffice/network-show' ? 'active' : '' }}">
                            <a href="#" class="nav-link sub-item-toggle">
                                <span class="feather-icon"><i data-feather="layout"></i></span><span>Network</span>
                            </a>
                            <div class="sub-menu">
                                <ul>
                                    <li><a href="{!! route('network') !!}">Binary Tree</a></li>
                                    <li><a href="{!! route('binaryd') !!}">Business</a></li>
                                    <li><a href="{!! route('referrals') !!}">Direct Referral</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item sub-item {{ Request::path() == 'backoffice/plan' ? 'active' : '' }} {{ Request::path() == 'backoffice/package' ? 'active' : '' }}">
                            <a href="#" class="nav-link sub-item-toggle">
                                <span class="feather-icon"><i data-feather="file-text"></i></span><span>Packages</span>
                            </a>
                            <div class="sub-menu">
                                <ul>
                                    <li><a href="{!! route('plan.all') !!}">Buy</a></li>
                                    <li><a href="{!! route('package') !!}">Purchased</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item {{ Request::path() == 'backoffice/income' ? 'active' : '' }}">
                            <a href="{!! route('roi') !!}" class="nav-link">
                                <span class="feather-icon"><i data-feather="edit"></i></span><span>Earnings</span>
                            </a>
                        </li>
                        <li class="nav-item sub-item {{ Request::path() == 'backoffice/withdraw-BTC' ? 'active' : '' }} {{ Request::path() == 'backoffice/withdraw-log' ? 'active' : '' }} {{ Request::path() == 'backoffice/deposit-history' ? 'active' : '' }}">
                            <a href="#" class="nav-link sub-item-toggle">
                                <span class="feather-icon"><i data-feather="menu"></i></span><span>Financials</span>
                            </a>
                            <div class="sub-menu">
                                <ul>
                                    <li><a href="{!! route('withdraw-request-bitcoin') !!}">Withdraw</a></li>
                                    <li><a href="{!! route('withdraw-log') !!}">Withdraw History</a></li>
                                    <li><a href="{!! route('deposit-history') !!}">Deposit History</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item sub-item {{ Request::path() == 'backoffice/document' ? 'active' : '' }}">
                            <a href="#" class="nav-link sub-item-toggle">
                                <span class="feather-icon"><i data-feather="package"></i></span><span>Media</span>
                            </a>
                            <div class="sub-menu">
                                <ul>
                                    <li><a href="{!! route('document') !!}">Presentation</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item {{ Request::path() == 'backoffice/support-all' ? 'active' : '' }}">
                            <a href="{!! route('support-all') !!}" class="nav-link">
                                <span class="feather-icon"><i data-feather="layers"></i></span><span>Support</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div><!-- END / Main Menu -->
            
            
        </header><!-- END / Header -->

        <!-- Tovvl Main -->
        <div class="tovvl-main">
            <div class="container">
              @yield('content')
            </div>
        </div><!-- END / Tovvl Main -->
    </div> 
    <!-- =========================================================-->
    <!-- All Scripts -->
    <!-- ========================================================= -->
    <!-- jquery -->
    <script src="{{asset('assets/user1/vendor/jquery/js/jquery-3.3.1.min.js') }}"></script>
    <!-- bootstrap -->
    <script src="{{asset('assets/user1/vendor/popper/js/popper.min.js') }}"></script>
    <script src="{{asset('assets/user1/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- feather icons -->
    <script src="{{asset('assets/user1/vendor/feather/js/feather.min.js') }}"></script>
    <!-- perfect scrollbar -->
    <script src="{{asset('assets/user1/vendor/perfect-scrollbar/js/perfect-scrollbar.min.js') }}"></script>
    <!-- chat popup -->
    <script src="{{asset('assets/user1/js/chat.popup.js') }}"></script>
    <!-- main js -->
    <script src="{{asset('assets/user1/js/main.js') }}"></script>
    <!-- =========================================================-->
    <!-- Required for this page scripts -->
    <!-- ========================================================= -->
    <!-- select2 -->
    <script src="{{asset('assets/user1/vendor/select2/js/select2.full.min.js') }}"></script>
    <!-- bootstrap datepicker -->
    <script src="{{asset('assets/user1/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- chartjs -->
    <script src="{{asset('assets/user1/vendor/chartjs/js/chartjs.min.js') }}"></script>
    <!-- flot chart -->
    <script src="{{asset('assets/user1/vendor/flot/js/jquery.flot.min.js') }}"></script>
    <script src="{{asset('assets/user1/vendor/flot/js/jquery.flot.resize.min.js') }}"></script>
    <script src="{{asset('assets/user1/js/dashboard-2.js') }}"></script>
    <script src="{{asset('assets/user1/vendor/sweetalert/js/sweetalert.min.js') }}"></script>
    <!-- data table -->
    <script src="{{asset('assets/user1/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{asset('assets/user1/vendor/datatables/js/dataTables.responsive.min.js') }}"></script>

    
    <script>
        $(function(){
            $('#datatable1').DataTable({
                responsive: true,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: ''
                },
                
            });         

            $('#datatable2').DataTable({
                responsive: true,
                searching: false,
                bLengthChange: false
            });

            $('div.dataTables_filter input').addClass('form-control');
            $('div.dataTables_length select').addClass('form-control');
        });
    </script>
    <script>
        $(function(){
            // select 2
            $(".select2-multiple").select2();

            //boostrap datepicker
            $(".bs-datepicker").datepicker({
                format: "dd/mm/yyyy",
            });
        });
    </script>
    @if (session('message'))
    <script type="text/javascript">
        $(document).ready(function(){
            swal("{{ session('title') }}", "{{ session('message') }}", "{{ session('type') }}");
        });
    </script>
    @endif
    @if (session('success'))
        <script type="text/javascript">
            $(document).ready(function(){
                swal("Success!", "{{ session('success') }}", "success");
            });
        </script>
    @endif
    @if (session('alert'))
        <script type="text/javascript">
            $(document).ready(function(){
                swal("Sorry!", "{{ session('alert') }}", "error");
            });
        </script>
    @endif
    @if (session('error'))
        <script type="text/javascript">
            $(document).ready(function(){
                swal("Sorry!", "{{ session('error') }}", "error");
            });
        </script>
    @endif
    @if($errors->any())
        @php
            $message = implode('\n', $errors->all());
        @endphp
        <script type="text/javascript">
            $(document).ready(function(){
                swal("Error!", "{!! $message !!}", "error");
                {{--swal({--}}
                    {{--title: "Error!",--}}
                    {{--type: "error",--}}
                    {{--html: "{!! $message !!}"--}}
                {{--});--}}
            });
        </script>
    @endif
     @yield('script')
</body>

</html>