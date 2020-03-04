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
      color:#ffffff;
      outline: none !important;
      background-color: #3A3A3A !important;
    }
    input{
      color:#000000 !important;
      border: 1px solid #3449BD !important;
    }
    input[readonly]{
      color:#ffffff !important;
      border: 1px solid #3449BD !important;
      background-color: #3A3A3A !important;
    }
    </style>
@endsection
@section('content')
<div class="row row-md">
  <div class="col-12">
    @if($cashwallet && count($cashwallet))
        @foreach($cashwallet as $coin)
     <div class="card">
        <div class="card-header" style="background-color:#3A3A3A">
            <h4 class="text-white text-center m-auto mb-10"> Available Balance: <strong style="color:#3498DB;text-align: center !important;font-size:18px"> $ {!! $coin->balance !!} </strong></h4>
        </div>
        <div class="card-body">
            <label style="font-size:18px"><strong><code>Withdraw Charge : {{ $basic->withdraw_charge }}%</code></strong></label>
            <form method="post" action="{{ route('withdraw', 'BTC') }}">
                {{ csrf_field() }}
                <input type="hidden" name="miner_id" id="edit_cid" value="{{ $coin->id }}">
                <div class="modal-body">
                    <div class="row">
                       <div class="col-sm-12">
                        <div class="form-group">
                            <label>Bitcoin Wallet</label>
                            <input type="text" class="form-control"  name="bitcoin" id="bitcoin" value="{{ $passive[0]->wallet }}" placeholder="Bitcoin Wallet">
                        </div>
                        <div class="form-group">
                            <label>Amount</label>
                            <div class="input-group">
                                <input type="text" value="" id="amount" name="amount" class="form-control" required placeholder="Amount" />
                                <span class="input-group-btn">
                                  <span class="btn-c py-5 px-5" type="button" data-placement="button">{{ $basic->currency }}</span>
                                </span>
                            </div>
                        </div>
                        </div>
                            <br>
                            <br>
                        <div class="col-6 m-auto">
                            <button type="submit" class="mt-10 btn btn-primary btn-block btn-own">Withdraw Now</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
     </div>
     @endforeach
    @else
        <h1 class="text-danger text-center">You Have No Coin Balance For Withdraw</h1>
    @endif
  </div>
</div>
@endsection

@section('script')
     <script type="text/javascript">
        $(document).ready(function(){
            var input = document.getElementById('bitcoin');
            if(input.value.length != 0){
                input.readOnly = true;
            }

            var pos = document.getElementById('p');
            if(pos.value.length != 0){
                pos.readOnly = true;
            }
        });
    </script>
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