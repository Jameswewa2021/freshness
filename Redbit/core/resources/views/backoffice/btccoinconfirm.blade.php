@extends('layouts.user-frontend.user-dashboard')

@section('content')
<style type="text/css">
	#btcp{
		width: 50%;
		min-width: 50%;
		 transform: translateY(20%);
		  -webkit-transform: translateY(20%);
		  -moz-transform: translateY(20%);
	}

	@media screen and (max-width: 900px){
		#btcp{
		width: 100%;
		min-width: 100%;
		 transform: translateY(5%);
		  -webkit-transform: translateY(5%);
		  -moz-transform: translateY(5%);
	}
	}
</style>
    <div id="btcp" class="container-fluid">  
	<div class="row">
	<div class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading" style="background-color:#00ADEF !important">
			<h3 style="font-size: 20px; color: #ffffff" class="panel-title">Confirm Deposit</h3>
		</div>
		<div class="panel-body">

			<div  class="col-md-8 col-md-offset-2 text-center">

				<h1><i class="fa fa-usd"></i> <span class="text-info">{{$amon}}</span> <i class="fa fa-exchange"></i> <i class="fa fa-bitcoin"></i> <span class="text-info">{{ $bcoin }}</span></h1>

			
			<b style="color: red; margin-top: 15px;"> Minimum 3 Confirmation Required to Credited Your Account.<br/>(It May Take Upto 2 to 24 Hours)</b>
			<br/>
			<p style="margin-top: 15px;">{!! $form !!}</p>
			</div>
			

		</div>
	</div>
	</div>
	</div>
		</div>
@endsection