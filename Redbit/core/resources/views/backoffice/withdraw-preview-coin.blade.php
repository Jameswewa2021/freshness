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
    </style>
@endsection
@section('content')
<div class="row row-md">
  <div class="col-12">
     <div class="card">
        <div class="card-header" style="background-color:#3A3A3A">
            <h4 class="text-white text-center m-auto mb-10">Withdraw Overview</h4>
        </div>
        <div class="card-body">
            <div class="col-12">
                <div class="form-horizontal form-user-profile row mt-1">
                    <div class="col-md-6">
                        <label><strong>Withdraw Amount</strong></label>
                        <div class="input-group">
                            <input type="text" value="{{ $withdraw->amount }}" readonly name="amount" id="amount" class="form-control" placeholder="Enter Deposit Amount" required>
                            <span class="input-group-btn">
                              <span class="btn-c py-5 px-5" type="button" data-placement="button">{{ $basic->currency }}</span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label><strong>Charges</strong></label>
                        <div class="input-group">
                            <input type="text" value="{{ $withdraw->charge }}" readonly name="charge" id="charge" class="form-control" placeholder="Enter Deposit Charge" required>
                            <span class="input-group-btn">
                              <span class="btn-c py-5 px-5" type="button" data-placement="button">{{ $basic->currency }}</span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label><strong>Total Amount</strong></label>
                        <div class="input-group">
                            <input type="text" value="{{ $withdraw->net_amount }}" readonly name="charge" id="charge" class="form-control" placeholder="Enter Deposit Amount" required>
                            <span class="input-group-btn">
                              <span class="btn-c py-5 px-5" type="button" data-placement="button">{{ $basic->currency }}</span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label><strong>Balance after Withdraw</strong></label>
                        <div class="input-group">
                            <input type="text" value="{{ $data->balance - $withdraw->amount }}" readonly class="form-control" required>
                            <span class="input-group-btn">
                              <span class="btn-c py-5 px-5" type="button" data-placement="button">{{ $basic->currency }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="col-12">
                {!! Form::open(['route'=>'withdraw-submit']) !!}
                <input type="hidden" name="withdraw_id" value="{{ $withdraw->id }}">
                <div class="form-horizontal form-user-profile row mt-1">
                    <div class="col-md-6">
                        @if($withdraw->type=='PM')
                        <!-- <label><strong>PM Account</strong></label> -->
                        <input type="text" required name="wall" value="{{ $pwallet }}" hidden readonly>
                        @elseif($withdraw->type=='BTC')
                        <!-- <label><strong>BTC Wallet</strong></label> -->
                        <input type="text" required name="wall" value="{{ $pwallet }}" hidden readonly>
                        @endif
                    </div>
                    <br>
                    <div class="col-md-12">
                        <button  class="mt-10 btn btn-primary btn-block btn-own">Withdraw Fund</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div> 
        </div>
     </div>
  </div>
</div>
@endsection