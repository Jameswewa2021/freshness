@extends('layouts.dashboard')
@section('style')

    <link href="{{ asset('assets/admin/css/bootstrap-toggle.min.css') }}" rel="stylesheet">


@endsection
@section('content')


        <div class="row">
            <div class="col-md-12">


                <div class="portlet blue box">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <strong>User Details</strong>
                        </div>
                        <div class="tools"> </div>
                    </div>
                    <div class="portlet-body" style="overflow:hidden;">

                        <div class="col-md-3">
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption uppercase bold">
                                        <i class="fa fa-user"></i> PROFILE </div>
                                </div>
                                <div class="portlet-body text-center" style="overflow:hidden;">
                                    <img src="@if($user->image == 'user-default.png') {{ asset('assets/images/user-default.png') }} @else {{ asset('assets/images') }}/{{ $user->image }}@endif" class="img-responsive propic" alt="Profile Pic">

                                    <hr><h4 class="bold">User Name : {{ $user->username}}</h4>
                                    <h4 class="bold">Name : {{ $user->name }}</h4>
                                    <h4 class="bold">BALANCE : {{ $user->balance }} {{ $basic->currency }}</h4>
                                    <hr>
                                    @if($user->login_time != null)
                                        <p>
                                            <strong>Last Login : {{ \Carbon\Carbon::parse($user->login_time)->diffForHumans() }}</strong> <br>
                                        </p>
                                    <hr>
                                    @endif
                                    @if($last_login != null)
                                    <p>
                                        <strong>Last Login From</strong> <br> {{ $last_login->user_ip }} -  {{ $last_login->location }} <br> Using {{ $last_login->details }} <br>
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="portlet box purple">
                                        <div class="portlet-title">
                                            <div class="caption uppercase bold">
                                                <i class="fa fa-desktop"></i> Details </div>
                                            <div class="tools"> </div>
                                        </div>
                                        <div class="portlet-body">

                                            <div class="row">

                                                <a href="{{ route('user-deposit-all',$user->username) }}">
                                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="margin-bottom: 20px;">
                                                        <div class="dashboard-stat green">
                                                            <div class="visual">
                                                                <i class="fa fa-cloud-upload"></i>
                                                            </div>
                                                            <div class="details">
                                                                <div class="number">
                                                                    <span data-counter="counterup" data-value="{{ $total_deposit }}">0</span>
                                                                </div>
                                                                <div class="desc uppercase bold "> DEPOSIT </div>
                                                            </div>
                                                            <div class="more">
                                                                <div class="desc uppercase bold text-center">
                                                                    {{ $basic->symbol }}
                                                                    <span data-counter="counterup" data-value="{{ $total_deposit_amount }}">0</span> DEPOSIT
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <!-- END -->

                                                <a href="{{ route('plan.logs.user', $user->id) }}">
                                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="margin-bottom: 20px;">
                                                        <div class="dashboard-stat red">
                                                            <div class="visual">
                                                                <i class="fa fa-network"></i>
                                                            </div>
                                                            <div class="details">
                                                                <div class="number">
                                                                    <span data-counter="counterup" data-value="{{ $plan_logs }}">0</span>
                                                                </div>
                                                                <div class="desc uppercase  bold "> Purchased package </div>
                                                            </div>
                                                            <div class="more">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <!-- END -->

                                                <a href="{{ route('user-login-all',$user->username) }}">
                                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="margin-bottom: 20px;">
                                                        <div class="dashboard-stat yellow">
                                                            <div class="visual">
                                                                <i class="fa fa-sign-in"></i>
                                                            </div>
                                                            <div class="details">
                                                                <div class="number">
                                                                    <span data-counter="counterup" data-value="{{ $total_login }}">0</span>
                                                                </div>
                                                                <div class="desc uppercase  bold "> Log In </div>
                                                            </div>
                                                            <div class="more">
                                                                <div class="desc uppercase bold text-center">
                                                                    VIEW DETAILS
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <!-- END -->

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="portlet box blue-ebonyclay">
                                        <div class="portlet-title">
                                            <div class="caption uppercase bold">
                                                <i class="fa fa-cogs"></i> Operations </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="row" style="margin-bottom: 5px">
                                                <div class="col-md-12 uppercase">
                                                    <button class="btn btn-danger withc btn-lg btn-block"><i class="fa fa-envelope-open"></i>Set Package</button>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-bottom: 5px">
                                                <div class="col-md-12 uppercase">
                                                    <button class="btn btn-danger withp btn-lg btn-block"><i class="fa fa-envelope-open"></i>Package with point</button>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-bottom: 5px">
                                                <div class="col-md-12 uppercase">
                                                    <button class="btn btn-danger withpr btn-lg btn-block"><i class="fa fa-envelope-open"></i>Package ROI without point</button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 uppercase">
                                                    <a href="{{ route('user-send-mail',$user->id) }}" class="btn btn-success btn-lg btn-block"><i class="fa fa-envelope-open"></i> Send Email</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="portlet box green">
                                        <div class="portlet-title">
                                            <div class="caption uppercase bold">
                                                <i class="fa fa-cog"></i> Update Profile </div>
                                        </div>
                                        <div class="portlet-body">

                                            <form action="{{ route('user-details-update') }}" method="post">

                                                {!! csrf_field() !!}

                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                <div class="row uppercase">

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="col-md-12"><strong>Name</strong></label>
                                                            <div class="col-md-12">
                                                                <input class="form-control input-lg" name="name" value="{{ $user->name }}" type="text">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="col-md-12"><strong>Email</strong></label>
                                                            <div class="col-md-12">
                                                                <input class="form-control input-lg" name="email" value="{{ $user->email }}" type="text">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="col-md-12"><strong>Phone</strong></label>
                                                            <div class="col-md-12">
                                                                <input class="form-control input-lg" name="phone" value="{{ $user->phone }}" type="text">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4" style="margin-top: 5px">
                                                        <div class="form-group">
                                                            <label class="col-md-12"><strong>E-wallet</strong></label>
                                                            <div class="col-md-12">
                                                                <input class="form-control input-lg" name="ewallet" value="{{ $user->ewallet }}" type="text">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4" style="margin-top: 5px">
                                                        <div class="form-group">
                                                            <label class="col-md-12"><strong>Dstar</strong></label>
                                                            <div class="col-md-12">
                                                                <input class="form-control input-lg" name="dstar" value="{{ $user->dstar }}" type="text">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4" style="margin-top: 5px">
                                                        <div class="form-group">
                                                            <label class="col-md-12"><strong>Limit</strong></label>
                                                            <div class="col-md-12">
                                                                <input class="form-control input-lg" name="r_limit" value="{{ $user->r_limit }}" type="text">
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div><!-- row -->

                                                <br><br>
                                                <div class="row uppercase">


                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="col-md-12"><strong>STATUS</strong></label>
                                                            <div class="col-md-12">
                                                                <input data-toggle="toggle" {{ $user->status == 0 ? 'checked' : ''}} data-onstyle="success" data-size="large" data-offstyle="danger" data-on="Active" data-off="Blocked"  data-width="100%" type="checkbox" name="status">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="col-md-12"><strong>EMAIL VERIFICATION</strong></label>
                                                            <div class="col-md-12">
                                                                <input data-toggle="toggle" {{ $user->email_verify == 1 ? 'checked' : ''}} data-onstyle="success" data-size="large" data-offstyle="danger" data-on="Verified" data-off="Not Verified"  data-width="100%" type="checkbox" name="email_verify">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="col-md-12"><strong>PHONE VERIFICATION</strong></label>
                                                            <div class="col-md-12">
                                                                <input data-toggle="toggle" {{ $user->phone_verify == 1 ? 'checked' : ''}} data-onstyle="success" data-size="large" data-offstyle="danger" data-on="Verified" data-off="Not Verified"  data-width="100%" type="checkbox" name="phone_verify">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div><!-- row -->

                                                <br><br>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn blue btn-block btn-lg">UPDATE</button>
                                                    </div>
                                                </div>

                                            </form>

                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div><!-- col-9 -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="portlet box blue">
                                    <div class="portlet-title">
                                        <h4 class="bold">Direct Referral</h4>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="caption font-white">
                                            <p>Direct Referral</p>
                                        </div>
                                        @if(count($ref))
                                        <table class="table table-striped table-bordered table-hover" id="sample_1">
                                            <thead>
                                            <tr>
                                                <th>ID#</th>
                                                <th>Register At</th>
                                                <th>Name</th>
                                                <th>User Name</th>
                                                <th>Email</th>
                                                <th>Balance</th>
                                                <th>Status</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php $i=0;@endphp
                                            @foreach($ref as $p)
                                                @php $i++;@endphp
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($p->created_at)->format('d F Y h:i A') }}</td>
                                                    <td>{{ $p->name }}</td>
                                                    <td>{{ $p->username }}</td>
                                                    <td>{{ $p->email }}</td>
                                                    <td>
                                                        {{ $p->balance }} - {{ $basic->currency }}
                                                    </td>
                                                    <td>
                                                        @if($p->balance > 0 && $p->dstar != 1)
                                                          <span class="btn  bold uppercase btn-success btn-sm">Active</span>
                                                        @else
                                                          <span class="btn  bold uppercase btn-danger btn-sm">In active</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                        @else
                                            <div class="text-center">
                                                <h3>No User Found</h3>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div><!-- ROW-->
                    </div>
                </div>

            </div>
        </div><!-- ROW-->

<div class="modal" id="withc">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><strong><span id="edit_cname"></span> Select Package</strong> </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form method="post" action="{{ route('setpackage') }}">
                {{ csrf_field() }}
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <div class="modal-body">
                    <div class="row">
                       <div class="col-sm-12">
                            <label><strong>Select Package Amount</code></strong></label>
                            <select id="pack" required name="pack" class="form-control single-select">
                                @php $i=0;@endphp
                                @foreach($pack as $p)
                                @php $i++;@endphp
                                   <option>{{$p->amount}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12" style="margin-top: 1.5rem">
                            <button type="submit" class=" btn btn-primary btn-block btn-own">Select</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal" id="withp">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><strong><span id="edit_cname"></span> Select Package with point</strong> </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form method="post" action="{{ route('setpackagep') }}">
                {{ csrf_field() }}
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <div class="modal-body">
                    <div class="row">
                       <div class="col-sm-12">
                            <label><strong>Select Package Amount</code></strong></label>
                            <select id="pack" required name="pack" class="form-control single-select">
                                @php $i=0;@endphp
                                @foreach($pack as $p)
                                @php $i++;@endphp
                                   <option>{{$p->amount}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12" style="margin-top: 1.5rem">
                            <button type="submit" class=" btn btn-primary btn-block btn-own">Select</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal" id="withpr">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><strong><span id="edit_cname"></span>Select Package ROI without point</strong> </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form method="post" action="{{ route('setpackagepr') }}">
                {{ csrf_field() }}
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <div class="modal-body">
                    <div class="row">
                       <div class="col-sm-12">
                            <label><strong>Select Package Amount</code></strong></label>
                            <select id="pack" required name="pack" class="form-control single-select">
                                @php $i=0;@endphp
                                @foreach($pack as $p)
                                @php $i++;@endphp
                                   <option>{{$p->amount}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12" style="margin-top: 1.5rem">
                            <button type="submit" class=" btn btn-primary btn-block btn-own">Select</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')

    <script src="{{ asset('assets/admin/js/bootstrap-toggle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/jquery.waypoints.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/admin/js/jquery.counterup.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $('.withc').click(function (e) {
                    e.preventDefault();
                    $('#withc').modal();
                });
    </script>
    <script type="text/javascript">
        $('.withp').click(function (e) {
                    e.preventDefault();
                    $('#withp').modal();
                });
    </script>
    <script type="text/javascript">
        $('.withpr').click(function (e) {
                    e.preventDefault();
                    $('#withpr').modal();
                });
    </script>

@endsection

