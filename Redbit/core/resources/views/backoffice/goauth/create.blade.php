@extends('layouts.user-frontend.user-dashboard')
@section('style')
<style type="text/css">
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
            <h4 class="text-white text-center m-auto mb-10"> 2FA Security</h4>
        </div>
        <div class="card-body text-center"> 
            @if(Auth::user()->tauth == '1')
              <div class="form-group">
                <label style="text-transform: capitalize;font-size:18px"><strong><code>use google authenticator to scan the QR code below or use the below code</code></strong></label><br/>
               <hr/>
                <h6 style="text-transform: capitalize;text-align: left !important;font-size:16px">Please save this code to recover your Google Authenticator</h6>
                <div class="input-group" >
                  <input type="text" value="{{$prevcode}}" class="form-control input-lg" id="code" readonly>
                  <span class="input-group-btn">
                    <button class="btn-c py-1 px-2" type="button" onclick="copy('code')" data-placement="button">Copy</button>
                  </span>
                </div>  
              </div>
              <div class="form-group my-2">
                  <img src="{{$prevqr}}">
              </div>
              <button type="button" class="mt-10 btn btn-danger btn-block btn-own" data-toggle="modal" data-target="#disableModal">Disable 2FA</button> 
              @else
              <div class="form-group">
                <label style="text-transform: capitalize;font-size:18px"><strong><code>use google authenticator to scan the QR code below or use the below code</code></strong></label><br/>
                <hr/>
                  <h6 style="text-transform: capitalize;text-align: left !important;font-size:16px">Please save this code to recover your Google Authenticator</h6>
                  <div class="input-group">
                    <input type="text" value="{{$secret}}" class="form-control input-lg" id="code" readonly>
                      <span class="input-group-btn">
                        <button class="btn-c py-5 px-5" type="button" onclick="copy('code')" data-placement="button">Copy</button>
                      </span>
                  </div>  
              </div>
              <div class="form-group my-3">
                       <img src="{{$qrCodeUrl}}">
                  </div>
              <button type="button" class="mt-15 btn btn-primary btn-block btn-own" data-toggle="modal" data-target="#enableModal">Enable 2FA</button>  
            @endif
        </div>
     </div>
  </div>
</div>    

<!--Enable Modal -->
<div id="enableModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Verify Your OTP</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>  
      </div>
      <div class="modal-body py-10 px-15">
        <form action="{{route('go2fa.create')}}" method="POST">
              {{csrf_field()}}
              <div class="form-group">
                <input type="hidden" name="key" value="{{$secret}}">
                <input type="text" class="form-control" name="code" placeholder="Enter Google Authenticator Code"> 
              </div>
               <div class="form-group">
                <button type="submit" class="btn btn-success">Verify</button>
              </div>
          </form>
      </div>
      <div class="modal-footer mt-0">
        <button type="button" class="btn-c py-1" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!--Disable Modal -->
<div id="disableModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Verify Your OTP to Disable</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button> 
      </div>
      <div class="modal-body py-10 px-15">
         <form action="{{route('disable.2fa')}}" method="POST">
            {{csrf_field()}}
            <div class="form-group">
              <input type="text" class="form-control" name="code" placeholder="Enter Google Authenticator Code"> 
            </div>
             <div class="form-group">
              <button type="submit" class="btn btn-success">Verify</button>
            </div>
          </form>
      </div>
      <div class="modal-footer mt-0">
        <button type="button" class="btn-c py-1" data-dismiss="modal">Close</button>
      </div>
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
  text: "Code Copied",
  icon: "success",
  button: "Ok",
});
}
</script>
@endsection