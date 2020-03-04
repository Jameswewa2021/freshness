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
        @if($methods)
            <div class="row">
            @foreach($methods as $method)
                <div class="col-md-3">
                    <div class="card" style="background-color:#3449BD !important">
                        <div class="card-header">
                            <h5 style="color: #fff;text-align: center"><strong>{{ $method->name }}</strong></h5>
                        </div>
                        {{ Form::open() }}
                        <!-- panel body -->
                        <div class="card-body">
                            <img width="100%" class="image-responsive" src="{{ asset('assets/images') }}/{{ $method->image }}" alt="{{ $method->name }}">
                        </div>
                        <input type="text" value="{{ app('request')->input('amo') }}" id="amount" name="amount" class="form-control" hidden required placeholder="Amount"/>
                        <input type="hidden" name="payment_type" value="{{$method->id}}">                      
                        <div class="card-footer" style="background-color:#3449BD !important">
                            <button class="btn-c py-2">Select</button>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            @endforeach
            </div>
        @endif
    </div>
</div>
@endsection