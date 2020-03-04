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
      background-color: #0716B6 !important;
      height: 100% !important;
    }
</style>
@endsection
@section('content')
   
<div class="main-content">  
    <div class="main-body">
        <div class="card-heading d-flex a-i-center j-c-between">
            <h4 class="card-heading-title">Packages</h4>
            <div class="card-heading-breadcrumb">
                <div class="breadcrumb-item"><a href="{!! route('plan.all') !!}">Packages &nbsp; <span style="visibility: hidden;position:absolute;height:0px;">{!! $email =Auth::user()->email !!}</span></a></div>
                <div class="breadcrumb-item active"><a href="#">BUY</a></div>
            </div>
            <!-- .... -->
<?php
session_start();
$_SESSION['em']=$email;
?>
            <!-- ....... -->
        </div> 
        <!-- price table 2-->
        <div class="price-table2 mt-50">
            @if($plan)
            @php $i = 0 @endphp
            @foreach($plan as $key => $package)
                @php $i++ @endphp
                @if($i%4 == 1)
            <div class="row">
                @endif
                <!-- price table item -->
                <div class="col-lg-3 col-md-12 mb-10">
                    <div class="price-table2-item bg-secondary">
                        <span class="title">{{ $package->title }}</span>
                        <span class="price"><sup>$</sup>{{ $package->price }}</span>
                        <div class="card-row">
                            <ul class="substances">
                                @if(@unserialize($package->features))
                                    @foreach(@unserialize($package->features) as $feature)
                                        <li> {{ $feature }}
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <a data-price="{{$package->price}}" data-name="{{ $package->title }}" class="buy btn btn-round btn-white mt-20 text-secondary">Buy Now</a>
                    </div>
                </div><!-- end / proice table item -->
                @if($i%4 == 0)                   
            </div> 
            @endif
            @endforeach
            @endif
        </div> <!-- end / price table 2-->
    </div>   
</div>
<div class="modal fade" id="mbuy" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
           <h4 class="modal-title text-dark">Buy Package</h4>
           <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- <form method="post" action="{{ route('deposit-fund') }}" id="buy" name="myform"> -->
        <form method="post" action="../core/process.php" id="buy" name="myform">
            {{ csrf_field() }}
            <div class="modal-body">
              <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <p><strong >Selected Package: <span id="nam"></span></strong></p>
                            <label><strong >Amount</strong></label>
                            <input type="text" value="" id="amount" name="amount" class="form-control" readonly="readonly" required placeholder="Amount" style="border:2px solid #000000;color:#000000 !important" />
                        </div>
                        <input type="hidden" name="payment_type" value="3">
                        <br>
                        <br>
                        <div class="col-sm-12 text-center">
                            <button style="width: 50%" type="submit" class="text-center btn-c py-3">Procced to payment</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
      </div>
    </div>
</div>    
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('.buy').click(function (e) {
                e.preventDefault();
                var price = $(this).data('price');
                var name = $(this).data('name');
                $('#nam').text(name);
                $('#amount').val(price);
                $('#mbuy').modal();
            });
        });
    </script>
@endsection