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
      background-color: #4D4D4D !important;
      height: 100% !important;
    }
    .btn-s{
      width: 100% !important;
      border-radius: 0px !important;
      border:0 !important;
      cursor: pointer;
      font-weight:700;
      color:#000;
      outline: none !important;
      background-color: #fff !important;
    }
    .bg-x{
      background: url('{{ asset('assets/user/img/promo.jpg') }}') no-repeat !important;
      background-size: cover !important;
    }
</style>
@endsection
@section('content')
<div class="row row-md">
    @if($balances)
    @foreach($balances as $b)
    <div class="col-lg-3 col-md-3">
        <div class="card card-hover widget11" style="background-color: #3A3A3A !important">
            <div class="card-body pb-0">
                <div class="d-flex a-i-center j-c-between ln-20">
                    <div class="d-flex a-i-center">
                        <div class="widget11-value" style="color: #3498DB !important">${{ $b->balance }}</div>
                    </div>
                </div>
                <div class="widget11-label text-white">{{ $b->miner->name }}</div>
                <div class="card-row">
                    <div class="h-40 mt-20">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @endif
</div>
<!--<div class="row">-->
<!--    <div class="col-12 ">-->
<!--      <div class="bg-x card">-->
<!--        <div class="card-header pb-1">-->
<!--            <div class="card-title-wrap bar-white">-->
<!--                <h4 class="card-title text-white">Promotion</h4>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="card-content">-->
<!--            <div class="px-3 text-white">-->
<!--                <div class="align-center float-left">-->
<!--                    <p><span style="color:#FFCF00;font-weight: Bold;font-size: 20px">1st March to 30th April</span><br>Win a tour to Dubai on sale of $25000 on weaker leg.</p>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--      </div>-->
<!--    </div>-->
<!--</div>-->
<div class="row row-md">
    <div class="col-lg-3">
        <div class="card text-white" style="background-color:#3498DB !important ">
            <div class="card-header">
                <div class="card-title">
                    <h4 class="text-white">Portfolio</h4>
                </div>
            </div>
            <div class="card-body">
                <div class="fs-32 fw-700 ln-1 mb-20">${{round($balance->balance, $basic->deci) }}</div>
                <div class="mb-10">
                    <div class="d-flex a-i-center j-c-between mb-10">
                        <span class="fs-14 fw-600">Total Packages</span>
                        <span class="fs-20">{{$tpack}}</span>
                    </div>
                    <div class="progress h-3">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <div class="mb-10">
                    <div class="d-flex a-i-center j-c-between mb-10">
                        <span class="fs-14 fw-600">Earning Limit</span>
                        <span class="fs-18">{{$user->r_limit}}</span>
                    </div>
                    <div class="progress h-3">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <div class="mb-10">
                    <div class="d-flex a-i-center j-c-between mb-10">
                        <span class="fs-14 fw-600">Binary Status</span>
                        <span class="fs-18">{{$bstatus}}</span>
                    </div>
                    <div class="progress h-3">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                
                <div class="mb-10">
                    <div class="d-flex a-i-center j-c-between mb-10">
                        <span class="fs-14 fw-600">Left Business</span>
                        <span class="fs-18">{{$point_left}}</span>
                    </div>
                    <div class="progress h-3">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <div class="mb-10">
                    <div class="d-flex a-i-center j-c-between mb-10">
                        <span class="fs-14 fw-600">Right Business</span>
                        <span class="fs-18">{{$point_right}}</span>
                    </div>
                    <div class="progress h-3">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <div class="d-flex mt-20">
                    <a href="{!! route('plan.all') !!}"><button class="btn btn-primary mr-10 d-flex a-i-center" >
                        <span class="ln-0"><i data-feather="refresh-ccw" class="w-15 h-15 mr-5"></i></span>
                        Invest
                    </button></a>
                    <button class="btn btn-dark mr-10 d-flex a-i-center">
                        <span class="ln-0"><i data-feather="log-out" class="w-15 h-15 mr-5"></i></span>
                        Withdraw
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-9 col-md-12" style="height: 455px">
        <!-- TradingView Widget BEGIN -->
        <div class="tradingview-widget-container">
          <div id="tv-medium-widget"></div>
          <div class="tradingview-widget-copyright"></div>
          <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
          <script type="text/javascript">
          new TradingView.MediumWidget(
          {
          "container_id": "tv-medium-widget",
          "symbols": [
            [
              "Bitcoin",
              "COINBASE:BTCUSD|12m"
            ],
            [
              "EURUSD",
              "FX:EURUSD|12m"
            ]
          ],
          "greyText": "Quotes by",
          "gridLineColor": "#e9e9ea",
          "fontColor": "rgba(0, 0, 0, 1)",
          "underLineColor": "rgba(159, 197, 232, 1)",
          "trendLineColor": "rgba(0, 0, 255, 1)",
          "width": "100%",
          "height": "100%",
          "locale": "en"
        }
          );
          </script>
        </div>
        <!-- TradingView Widget END -->
    </div>
</div>
<div class="row row-md">
    <div class="col-12 col-lg-4">
        <div class="card" style="background-color: #3498DB !important">
            <div class="card-header">
                <h4 class="card-title text-white">Your Rank</h4>
            </div>
            <div class="card-body">
                <h1 class="text-center text-white">{{$level}}</h1>
                <div class="card" style="margin: 0 !important">
                    <div class="card-body text-white">
                        <p class="float-left mr-5 mb-0" style="font-size: 17px;font-weight: 500">Next Rank: </p>
                        <p style="font-size: 17px;font-weight: 300" class="mb-0"> {{$next_level}}</p>
                        <p class="float-left mr-5 mb-0" style="font-size: 17px;font-weight: 500">Your Total: </p>
                        <p style="font-size: 17px;font-weight: 300" class="mb-0">${{$t_points}}</p>
                        <p class="float-left mr-5 mb-0" style="font-size: 17px;font-weight: 500">For Next Rank: </p>
                        <p style="font-size: 17px;font-weight: 300" class="mb-0">${{$level_points}}</p>
                    </div>
                </div> 
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-8">
        <div class="card" style="background-color: #93096A !important;">
            <div class="card-header">
                <h4 class="card-title text-white">Your Referral Link</h4>
            </div>
            <div class="card-body text-white mb-20 mt-20" >
                <div  class="col-12">
                    <label style="font-size: 16px">Left Placement</label>
                    <div class="input-group" >
                        <input style="background-color:#fff;border-color:#fff" id="refl-copy" type="text" class="form-control" value="{{url('/register?refid='.Auth::user()->username.'&p=Left')}}" readonly>
                        <span class="input-group-btn">
                          <button class="btn-c px-10 py-1" type="button" onclick="copy('refl-copy')" data-placement="button">Copy</button>
                        </span>
                    </div>
                </div>
                <div class="col-12">
                    <label style="font-size: 16px">Right Placement</label>
                    <div class="input-group">
                        <input style="background-color:#fff;border-color:#fff" id="refr-copy" class="form-control" type="text" readonly value="{{url('/register?refid='.Auth::user()->username.'&p=Right')}}">
                        <span class="input-group-btn">
                          <button class="btn-c px-10 py-1" type="button" onclick="copy('refr-copy')" data-placement="button">Copy</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 

<!-- Wallet  tranfer -->
 <div class="modal fade" id="ctModal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
           <h4 class="modal-title text-dark">Transfer</h4>
           <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form method="post" action="{{ route('ctmodal') }}">
            {{ csrf_field() }}
            <div class="modal-body">
              <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-sm-12 text-dark">
                                <p style="color:#FF0000">There will be no transfer fee</p>
                                <input type="text" value="" id="username" name="username" class="form-control mb-2" required placeholder="Username" />
                                <div class="input-group" style="margin-top: 10px;margin-bottom: 10px;">
                                    <input type="text" value="" id="amount" name="amount" class="form-control" required placeholder="Amount" />
                                    <span class="input-group-addon">&nbsp;<strong>USD</strong></span>
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="form-group">
                            <div class="col-sm-12 text-center">
                                <button style="width: 50%" type="submit" class="text-center btn-c py-2">Confirm</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Wallet  buy package -->
  <div class="modal fade" id="cbModal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
           <h4 class="modal-title text-dark">Buy Package</h4>
           <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form method="post" action="{{ route('cbmodal') }}">
            {{ csrf_field() }}
            <div class="modal-body">
              <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-sm-12 text-dark">
                                <input type="text" value="" id="username" name="username" class="form-control mb-2" required placeholder="Username" />
                                <h6 class="mb-1">Select Package</h6>
                                <select id="amount" required name="amount" class="form-control">
                                    @php $i=0;@endphp
                                    @foreach($pack as $p)
                                    @php $i++;@endphp
                                       <option>{{$p->amount}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="form-group">
                            <div class="col-sm-12 text-center">
                                <button style="width: 50%" type="submit" class="text-center btn-c py-2">Confirm</button>
                            </div>
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
<script type="text/javascript">
var copy = function(elementId) {

	var input = document.getElementById(elementId);
	var isiOSDevice = navigator.userAgent.match(/ipad|iphone/i);

	if (isiOSDevice) {
	  
		var editable = input.contentEditable;
		var readOnly = input.readOnly;

		input.contentEditable = true;
		input.readOnly = false;

		var range = document.createRange();
		range.selectNodeContents(input);

		var selection = window.getSelection();
		selection.removeAllRanges();
		selection.addRange(range);

		input.setSelectionRange(0, 999999);
		input.contentEditable = editable;
		input.readOnly = readOnly;

	} else {
	 	input.select();
	}

	document.execCommand('copy');
	swal({
  title: "Good job!",
  text: "Link Copied",
  icon: "success",
  button: "Ok",
});
}
</script>
@endsection
