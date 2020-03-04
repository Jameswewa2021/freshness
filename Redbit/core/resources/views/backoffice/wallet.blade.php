@extends('layouts.user-frontend.user-dashboard')
@section('style')
    <style>
        input[type="text"] {
            width: 100%;
            background-color: #ffffff !important;
            padding: 15px !important;
            border:1px solid rgba(0,0,0,0.2) !important;
        }
    </style>
@endsection
@section('content')

        <div class="container">
<br>

<div class="clearfix"></div>
    <br>
            <div class="row">
                <div class="login-admin login-admin1">
                    <div class="login-header text-center" style="margin-bottom: 15px;">
                        <h6>{!! $page_title  !!}</h6>
                    </div>
                    {!! Form::open(['method'=>'post','role'=>'form','class'=>'form-horizontal','files'=>true]) !!}
                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="row">

                                @if($passive)

                                    @foreach($passive as $user_data)

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;">BTC Wallet :</strong></label>
                                                <div class="col-md-12">
                                                    <input type="text" name="{{ $user_data->category_id }}" id="" value="{{ $user_data->wallet }}" placeholder="BTC Wallet">
                                                </div>
                                            </div>
                                        </div>

                                @endforeach

                                @endif
                                @if($binary)

                                    @foreach($binary as $user_data)

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;">PM Account:</strong></label>
                                                <div class="col-md-12">
                                                    <input type="text" name="{{ $user_data->category_id }}" id="" value="{{ $user_data->wallet }}" placeholder="Perfect Money">
                                                </div>
                                            </div>
                                        </div>

                                @endforeach

                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12 text-center" >
                                <button style="width: 50%;display: inline-block;" type="submit" class="new-btn-submit">UPDATE WALLET</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
           {!! Form::close() !!}
        </div>
@endsection
@section('script')
    <script type="text/javascript">
    $(document).ready(function(){
        var input = document.getElementById('b');
        if(input.value.length != 0){
            input.readOnly = true;
        }

        var pos = document.getElementById('p');
        if(pos.value.length != 0){
            pos.readOnly = true;
        }
    });
    </script>
    <script src="{{ asset('assets/admin/js/bootstrap-fileinput.js') }}"></script>

    @if (session('message'))

        <script type="text/javascript">

            $(document).ready(function(){

                swal("{{ session('title') }}", "{{ session('message') }}", "{{ session('type') }}");

            });

        </script>

    @endif

    @if (session('alert'))

        <script type="text/javascript">

            $(document).ready(function(){

                swal("Sorry!", "{!! session('alert') !!}", "error");

            });

        </script>

    @endif
@endsection
