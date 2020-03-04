@extends('layouts.user-frontend.user-dashboard')
@section('style')
    <style>
        .btn-c{
      width: 100% !important;
      height: 100% !important;
      border-radius: 0px !important;
      border:0 !important;
      cursor: pointer;
      font-weight:700;
      color:#000;
      outline: none !important;
      background-color: #fff !important;
    }
    </style>
@endsection
@section('content')
<div class="row">
     @if($cashwallet && count($cashwallet))
        @foreach($cashwallet as $coin)
            <div class="col-md-3 text-center">
                <div class="card" style="background-color:#3449BD !important">
                    <div class="card-header">
                        <h5 style="color: #ffffff"><b>Cash Wallet</b></h5>
                    </div>
                    <div class="card-body">
                        <ul style='font-size: 15px;' class="list-group text-center bold">
                            <li class="list-group-item">Balance: <b>$ {!! $coin->balance !!}</b>  </li>
                            <li class="list-group-item">Charge: {{ $basic->withdraw_charge }}% </li>
                        </ul>
                    </div>
                    <div class="card-footer" style="background-color:#3449BD !important">
                        <button href="#" @if($basic->withdraw_status == 0) disabled @endif class="btn-c py-2 withc" data-code="{{ $coin->miner->code }}" data-id="{{ $coin->id }}"> Withdraw</button>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <h1 class="text-danger text-center">You Have No Coin Balance For Withdraw</h1>
    @endif

</div>

<div class="modal fade" id="withd">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><strong>Withdraw via <span id="edit_name"></span></strong> </h4>
            </div>
            <form method="post" action="{{ route('withdraw', 'general') }}">
                {{ csrf_field() }}
                <input type="hidden" name="method_id" id="edit_id" value="">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <span style="margin-bottom: 10px;"><code>Withdraw Charge : (<span id="edit_fix"></span> {{ $basic->currency }} + <span id="edit_percent"></span>%)</code></span>
                                    <div class="input-group" style="margin-top: 10px;margin-bottom: 10px;">
                                        <input type="text" value="" id="amount" name="amount" class="form-control" required placeholder="Amount" />
                                        <span class="input-group-addon">&nbsp;<strong>{{ $basic->currency }}</strong></span>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary btn-block btn-own">Withdraw</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="withc">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><strong>Withdraw</strong> </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form method="post" action="{{ route('withdraw', 'PM') }}">
                {{ csrf_field() }}
                <input type="hidden" name="miner_id" id="edit_cid" value="">
                <div class="modal-body">
                    <div class="row">
                       <div class="col-sm-12">
                            <label><strong><code>Withdraw Charge : {{ $basic->withdraw_charge }}%</code></strong></label>
                            <div class="input-group">
                                <input type="text" value="" id="amount" name="amount" class="form-control" required placeholder="Amount" />
                                <span class="input-group-btn">
                                  <span class="btn-c py-1 px-1" type="button" data-placement="button">{{ $basic->currency }}</span>
                                </span>
                            </div>
                        </div>
                            <br>
                            <br>
                        <div class="col-sm-12">
                            <button type="submit" class="mt-3 btn btn-primary btn-block btn-own">Withdraw</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')

    @if (session('message'))

        <script type="text/javascript">

            $(document).ready(function(){

                swal("{{ session('title') }}", "{{ session('message') }}", "{{ session('type') }}");

            });

        </script>

    @endif

    @if (session('alert'))

        <script type="text/javascript">

            $(document).ready(function(){

                swal("Sorry!", "{!! session('alert') !!}", "error");

            });

        </script>

    @endif

    <script>
        (function ($) {
            $(document).ready(function(){

                $('.withb').click(function (e) {

                    e.preventDefault();

                    var id = $(this).data('id');
                    var name = $(this).data('name');
                    var fix = $(this).data('fix');
                    var percent = $(this).data('percent');

                    $('#edit_id').val(id);
                    $('#edit_name').text(name);
                    $('#edit_fix').text(fix);
                    $('#edit_percent').text(percent);

                    $('#withd').modal();
                });

                $('.withc').click(function (e) {
                    e.preventDefault();
                    var code = $(this).data('code');
                    var id = $(this).data('id');

                    $('#edit_cname').text(code);
                    $('#edit_cid').val(id);
                    $('#ccurrency').text(code);

                    $('#withc').modal();
                });

            });
        })(jQuery);
    </script>
@endsection