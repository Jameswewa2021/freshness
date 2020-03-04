@extends('layouts.user-frontend.user-dashboard')
@section('style')
<style type="text/css">
    input{
      color:#000000 !important;
      border: 1px solid #3449BD !important;
    }
  </style>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
      <div class="card">
          <div class="card-header">
              <div class="card-title-wrap bar-success">
                  <h4 class="card-title">Please Enter Google Authenticator Code</h4>
              </div>
          </div>
          <div class="card-body py-4">
            <div class="col-12">
              <form action="{{route('go2fa.verify') }}" method="POST">
                {{csrf_field()}}
                <div class="form-group">
                  <input type="text" class="form-control" name="code" placeholder="Enter Google Authenticator Code"> 
                </div>
                 <div class="form-group">
                  <button type="submit" class="btn btn-lg btn-success btn-block">Verify</button>
                </div>
             </form>
            </div>
          </div>
      </div>
  </div>
</div>
@endsection