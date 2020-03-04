@extends('layouts.user-frontend.user-dashboard')
@section('style')
<style type="text/css">
    .btn-c{
      width: 100% !important;
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
	<div class="col-12">
		<div class="card">
			<div class="card-header">
                <div class="card-title-wrap bar-success">
                    <h4 class="card-title">Select Payment Method</h4>
                </div>
             </div>
             
			<div class="card-body px-3 py-2">
				<div class="row">
					<div class="col-md-3">
						<div class="card" style="background-color:#3449BD !important">
							<div class="card-header">
				                <h5 style="color: #fff;text-align: center"><strong>Bitcoin</strong></h5>
				            </div>
							<div class="card-body">
								<img src="{{asset('assets/images/5b9ae32604d55.png')}}" width="100%" class="image-responsive">
							</div>
							<div class="card-footer" style="background-color:#3449BD !important">
								<!--<a href="{!! route('withdraw-request-bitcoin') !!}">-->
				    <!--            <button class="btn-c py-2">Select</button></a>-->
				                <button class="btn-c py-2">Select</button>
				            </div>
						</div>
					</div>

					<div class="col-md-3">
						<div class="card" style="background-color:#3449BD !important">
							<div class="card-header">
					            <h5 style="color: #fff;text-align: center"><strong>Perfect Money</strong></h5>
					        </div>
							<div class="card-body">
								<img src="{{asset('assets/images/usmanali.png')}}" width="100%" class="image-responsive">
							</div>
							<div class="card-footer" style="background-color:#3449BD !important">
								<!--<a href="{!! route('withdraw-request') !!}">-->
				    <!--            <button class="btn-c py-2">Select</button></a>-->
				                <button class="btn-c py-2">Select</button>
				            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function(){
      $("button").click(function(){
        swal("Sorry!", "System is under maintenace withdraw cannot be proccessed", "warning");
      });
    });
 </script>
@endsection