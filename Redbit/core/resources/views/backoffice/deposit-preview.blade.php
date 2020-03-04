@extends('layouts.user-frontend.user-dashboard')
@section('style')
<style type="text/css">
    .btn-c{
      width: 100% !important;
      border-radius: 0px !important;
      border:0 !important;
      cursor: pointer;
      font-weight:700;
      color:#fff;
      outline: none !important;
      background-color: #3449BD !important; 
    }
</style>
@endsection
@section('content')
<div class="row">
    @if($fund)
    <div class="col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-header">
                    <div class="card-title-wrap bar-success">
                        <h4 class="card-title">{{ $page_title }}</h4>
                    </div>
                </div>
                <div class="card-body px-3">
                    <div class="col-12">
                        <div class="form-horizontal form-user-profile row mt-1">
                            <div class="col-md-6">
                                <label><strong>Amount</strong></label>
                                <div class="input-group">
                                    <input type="text" value="{{ $fund->amount }}" readonly name="amount" id="amount" class="form-control" placeholder="Enter Deposit Amount" required>
                                    <span class="input-group-btn">
                                      <span class="btn-c py-1 px-1" type="button" data-placement="button">{{ $basic->currency }}</span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label><strong>Activation Fee</strong></label>
                                <div class="input-group">
                                    <input type="text" value="{{ $fund->charge }}" readonly name="charge" id="charge" class="form-control" placeholder="Enter Deposit Amount" required>
                                    <span class="input-group-btn">
                                      <span class="btn-c py-1 px-1" type="button" data-placement="button">{{ $basic->currency }}</span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label><strong>Total Amount</strong></label>
                                <div class="input-group">
                                    <input type="text" value="{{ round($fund->net_amount, $basic->deci)  }}" readonly name="charge" id="charge" class="form-control" placeholder="Enter Deposit Amount" required>
                                    <span class="input-group-btn">
                                      <span class="btn-c py-1 px-1" type="button" data-placement="button">{{ $basic->currency }}</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <br>
                        <hr>
                        <div class="row">
                            <div class="col-sm-6">
                                <a href="{{ route('plan.all') }}" class="mb-1 btn btn-primary btn-block btn-icon icon-left btn-own">
                                    Go Back
                                </a>
                            </div>
                            <div class="col-sm-6">
                                <a class="btn btn-success btn-block bold btn-icon icon-left btn-own" href="{{ route('deposit', $fund->custom) }}">
                                    Deposit
                                </a>
                            </div>
                        </div>
                    </div>                  
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('script')
    @if (session('message'))

        <script type="text/javascript">

            $(document).ready(function(){

                swal("{{ (session('title') != NULL)?session('title'):'Success!' }}", "{{ session('message') }}", "{{ (session('type') != NULL)?session('type'):'success' }}");

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
@endsection
