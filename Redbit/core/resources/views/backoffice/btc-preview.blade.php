@extends('layouts.user-frontend.user-dashboard')

@section('content')
<div class="row row-md">
  <div class="col-12">
     <div class="card">
        <div class="card-header" style="background-color:#3A3A3A">
            <h4 class="text-white text-center m-auto mb-10"> SEND EXACTLY <strong style="color:#3498DB;text-align: center !important">{{ $usd }} BTC </strong> TO</h4>
        </div>
        <div class="card-body text-center"> 
            <div class="col-12 my-2">
                <strong class="text-info">{{ $add }}</strong><br><br>
                 {!! $code !!}
                 <br><br> <strong>SCAN TO SEND</strong><br>
                <strong style="color: red;">2 Confirmation are required before your package get activated</strong>
            </div>  
        </div>
     </div>
  </div>
</div>
@endsection

@section('script')
    @if (session('message'))

        <script type="text/javascript">

            $(document).ready(function(){

                swal("Success!", "{{ session('message') }}", "success");

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
