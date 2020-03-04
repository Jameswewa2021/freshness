@extends('layouts.user-frontend.user-dashboard')
@section('style')
<style type="text/css">
.btn-c{
      width: 100% !important;
      border-radius: 25px !important;
      border:0 !important;
      cursor: pointer;
      font-weight:700;
      color:#fff;
      outline: none !important;
      background-color: #3498DB !important; 
    }
.btn-s{
      width: 100% !important;
      border-radius: 25px !important;
      border:0 !important;
      cursor: pointer;
      font-weight:700;
      color:#fff;
      outline: none !important;
      background-color: #3498DB !important; 
    }
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body px-0">
                                    <div class="row py-2" style="background-color:#3498DB ">
                                    <div class="col-xs-12 col-md-6" >
                                    <p class="text-white text-left"><strong>Username: </strong><span>{{$name}}</span></p>
                                    </div>
                                    <div class="col-xs-12 col-md-6">
                                        <p class="text-white text-left"><strong>Sponser: </strong><span>{{$reference}}</span></p>
                                    </div>
                                  
                                    <div class="col-xs-12 col-md-6">
                                        <p class="text-white text-left"><strong>Left Referrals: </strong>   <span>{{$left}}</span></p>
                                    </div>
                                    <div class="col-xs-12 col-md-6">
                                        <p class="text-white text-left"><strong>Right Referrals: </strong>  <span>{{$right}}</span></p>
                                    </div>
                                    <div class="col-xs-12 col-md-6">
                                        <p class="text-white text-left"><strong>Business Left: </strong>  <span>{{$pl}}</span></p>
                                    </div>
                                    <div class="col-xs-12 col-md-6">
                                        <p class="text-white text-left"><strong>Business Right: </strong>  <span>{{$pr}}</span></p>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                <div class="col-12 py-3 px-3">
                   <a href="{!! route('network') !!}" class="float-none float-md-left"><button type="button" class="btn-s py-7 px-15 mb-2">Top</button></a>
                    <form action="{{route('network-show')}}" method="POST" class="float-none float-md-right">
                       {{ csrf_field() }}
                       <div class="position-relative has-icon-left">
                            <div class="row">
                                <div class="col-8">
                                    <input name="username" id="s" placeholder="Search ID" type="text" class="form-control round">
                                    <div class="form-control-position">
                                        <i class="ft-search info"></i>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <button type="submit" class="btn-c py-5 px-10">show</button>
                                </div>   
                            </div>
                        </div>
                   </form>       
                </div>
                <div class="col-12 px-0">
                    <div class="management-hierarchy mt-5 mb-3">
                        <div class="hv-container">
                            <div class="hv-wrapper">
                                <!-- Key component -->
                                <div class="hv-item">
                                    <div class="hv-item-parent">
                                        <a href="{{url('backoffice/network/showtrees?id='.$username[0]->username)}}"> 
                                        <div class="person">
                                            <img title="Name: {{ $username[0]->name."\n"}}Country: {{ $username[0]->country."\n"}}Balance: {{$username[0]->balance."\n"}}" src="{{ asset('assets/images') }}/{{ $username[0]->image }}">
                                            <p class="name">
                                                {{$username[0]->username}}
                                            </p>
                                        </div></a>
                                    </div>
                                    <div class="hv-item-children">
                                        <div class="hv-item-child">
                                            <div class="hv-item">
                                                <div class="hv-item-parent">
                                                    @if(count($pos1l) > 0)
                                                    <a href="{{url('backoffice/network/showtrees?id='.$pos1l[0]->username)}}"><div class="person">
                                                        <img title="Name: {{ $pos1l[0]->name."\n"}}Country: {{$pos1l[0]->country."\n"}}Balance: {{$pos1l[0]->balance."\n"}}" src="{{ asset('assets/images') }}/{{$pos1l[0]->image }}">
                                                        <p class="name">
                                                            {{$pos1l[0]->username}}
                                                        </p>
                                                    </div></a>
                                                    @else
                                                    <div class="person">
                                                        <img src="{{asset('assets/img/av.png')}}">
                                                        <p class="name">
                                                            None
                                                        </p>
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="hv-item-children">
                                                    <div class="hv-item-child">
                                                       <div class="hv-item-parent d"> 
                                                            @if(count($pos21l) > 0)
                                                            <a href="{{url('backoffice/network/showtrees?id='.$pos21l[0]->username)}}"><div class="person">
                                                                <img title="Name: {{ $pos21l[0]->name."\n"}}Country: {{$pos21l[0]->country."\n"}}Balance: {{$pos21l[0]->balance."\n"}}" src="{{ asset('assets/images') }}/{{$pos21l[0]->image }}">
                                                                <p class="name">
                                                                    {{$pos1l[0]->username}}
                                                                </p>
                                                            </div></a>
                                                            @else
                                                            <div class="person">
                                                                <img src="{{asset('assets/img/av.png')}}">
                                                                <p class="name">
                                                                    None
                                                                </p>
                                                            </div>
                                                            @endif
                                                        </div>
                                                        <div class="hv-item-children s">
                                                            <div class="hv-item-child">
                                                                @if(count($pos31l) > 0)
                                                                <a href="{{url('backoffice/network/showtrees?id='.$pos31l[0]->username)}}"><div class="person">
                                                                    <img title="Name: {{ $pos31l[0]->name."\n"}}Country: {{$pos31l[0]->country."\n"}}Balance: {{$pos31l[0]->balance."\n"}}" src="{{ asset('assets/images') }}/{{$pos31l[0]->image }}">
                                                                    <p class="name">
                                                                        {{$pos31l[0]->username}}
                                                                    </p>
                                                                </div></a>
                                                                @else
                                                                <div class="person">
                                                                    <img src="{{asset('assets/img/av.png')}}">
                                                                    <p class="name">
                                                                        None
                                                                    </p>
                                                                </div>
                                                                @endif
                                                            </div>
                                                            <div class="hv-item-child">
                                                                @if(count($pos31r) > 0)
                                                                <a href="{{url('backoffice/network/showtrees?id='.$pos31r[0]->username)}}"><div class="person">
                                                                    <img title="Name: {{ $pos31r[0]->name."\n"}}Country: {{$pos31r[0]->country."\n"}}Balance: {{$pos31r[0]->balance."\n"}}" src="{{ asset('assets/images') }}/{{$pos31r[0]->image }}">
                                                                    <p class="name">
                                                                        {{$pos31r[0]->username}}
                                                                    </p>
                                                                </div></a>
                                                                @else
                                                                <div class="person">
                                                                    <img src="{{asset('assets/img/av.png')}}">
                                                                    <p class="name">
                                                                        None
                                                                    </p>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="hv-item-child">
                                                        <div class="hv-item-parent d">
                                                            @if(count($pos21r) > 0)
                                                            <a href="{{url('backoffice/network/showtrees?id='.$pos21r[0]->username)}}"><div class="person">
                                                                <img title="Name: {{ $pos21r[0]->name."\n"}}Country: {{$pos21r[0]->country."\n"}}Balance: {{$pos21r[0]->balance."\n"}}" src="{{ asset('assets/images') }}/{{$pos21r[0]->image }}">
                                                                <p class="name">
                                                                    {{$pos22r[0]->username}}
                                                                </p>
                                                            </div></a>
                                                            @else
                                                            <div class="person">
                                                                <img src="{{asset('assets/img/av.png')}}">
                                                                <p class="name">
                                                                    None
                                                                </p>
                                                            </div>
                                                            @endif
                                                        </div>
                                                        <div class="hv-item-children s">
                                                            <div class="hv-item-child">
                                                                @if(count($pos32l) > 0)
                                                                <a href="{{url('backoffice/network/showtrees?id='.$pos32l[0]->username)}}"><div class="person">
                                                                    <img title="Name: {{ $pos32l[0]->name."\n"}}Country: {{$pos32l[0]->country."\n"}}Balance: {{$pos32l[0]->balance."\n"}}" src="{{ asset('assets/images') }}/{{$pos32l[0]->image }}">
                                                                    <p class="name">
                                                                        {{$pos32l[0]->username}}
                                                                    </p>
                                                                </div></a>
                                                                @else
                                                                <div class="person">
                                                                    <img src="{{asset('assets/img/av.png')}}">
                                                                    <p class="name">
                                                                        None
                                                                    </p>
                                                                </div>
                                                                @endif
                                                            </div>
                                                            <div class="hv-item-child">
                                                                @if(count($pos32r) > 0)
                                                                <a href="{{url('backoffice/network/showtrees?id='.$pos32r[0]->username)}}"><div class="person">
                                                                    <img title="Name: {{ $pos32r[0]->name."\n"}}Country: {{$pos32r[0]->country."\n"}}Balance: {{$pos32r[0]->balance."\n"}}" src="{{ asset('assets/images') }}/{{$pos32r[0]->image }}">
                                                                    <p class="name">
                                                                        {{$pos1l[0]->username}}
                                                                    </p>
                                                                </div></a>
                                                                @else
                                                                <div class="person">
                                                                    <img src="{{asset('assets/img/av.png')}}">
                                                                    <p class="name">
                                                                        None
                                                                    </p>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="hv-item-child">
                                            <div class="hv-item">
                                                <div class="hv-item-parent">
                                                    @if(count($pos1r) > 0)
                                                    <a href="{{url('backoffice/network/showtrees?id='.$pos1r[0]->username)}}"><div class="person">
                                                        <img title="Name: {{ $pos1r[0]->name."\n"}}Country: {{$pos1r[0]->country."\n"}}Balance: {{$pos1r[0]->balance."\n"}}" src="{{ asset('assets/images') }}/{{$pos1r[0]->image }}">
                                                        <p class="name">
                                                           {{$pos1r[0]->username}}
                                                        </p>
                                                    </div></a>
                                                    @else
                                                    <div class="person">
                                                        <img src="{{asset('assets/img/av.png')}}">
                                                        <p class="name">
                                                            None
                                                        </p>
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="hv-item-children">
                                                    <div class="hv-item-child">
                                                       <div class="hv-item-parent d">
                                                            @if(count($pos22l) > 0)
                                                            <a href="{{url('backoffice/network/showtrees?id='.$pos22l[0]->username)}}"><div class="person">
                                                                <img title="Name: {{ $pos22l[0]->name."\n"}}Country: {{$pos22l[0]->country."\n"}}Balance: {{$pos22l[0]->balance."\n"}}" src="{{ asset('assets/images') }}/{{$pos22l[0]->image }}">
                                                                <p class="name">
                                                                    {{$pos22l[0]->username}}
                                                                </p>
                                                            </div></a>
                                                            @else
                                                            <div class="person">
                                                                <img src="{{asset('assets/img/av.png')}}">
                                                                <p class="name">
                                                                    None
                                                                </p>
                                                            </div>
                                                            @endif
                                                        </div>
                                                        <div class="hv-item-children s">
                                                            <div class="hv-item-child">
                                                                @if(count($pos33l) > 0)
                                                                <a href="{{url('backoffice/network/showtrees?id='.$pos33l[0]->username)}}"><div class="person">
                                                                    <img title="Name: {{ $pos33l[0]->name."\n"}}Country: {{$pos33l[0]->country."\n"}}Balance: {{$pos33l[0]->balance."\n"}}" src="{{ asset('assets/images') }}/{{$pos33l[0]->image }}">
                                                                    <p class="name">
                                                                        {{$pos33l[0]->username}}
                                                                    </p>
                                                                </div></a>
                                                                @else
                                                                <div class="person">
                                                                    <img src="{{asset('assets/img/av.png')}}">
                                                                    <p class="name">
                                                                        None
                                                                    </p>
                                                                </div>
                                                                @endif
                                                            </div>
                                                            <div class="hv-item-child">
                                                                @if(count($pos33r) > 0)
                                                                <a href="{{url('backoffice/network/showtrees?id='.$pos33r[0]->username)}}"><div class="person">
                                                                    <img title="Name: {{ $pos33r[0]->name."\n"}}Country: {{$pos33r[0]->country."\n"}}Balance: {{$pos33r[0]->balance."\n"}}" src="{{ asset('assets/images') }}/{{$pos33r[0]->image }}">
                                                                    <p class="name">
                                                                        {{$pos33r[0]->username}}
                                                                    </p>
                                                                </div></a>
                                                                @else
                                                                <div class="person">
                                                                    <img src="{{asset('assets/img/av.png')}}">
                                                                    <p class="name">
                                                                        None
                                                                    </p>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="hv-item-child">
                                                        <div class="hv-item-parent d">
                                                            @if(count($pos22r) > 0)
                                                            <a href="{{url('backoffice/network/showtrees?id='.$pos22r[0]->username)}}"><div class="person">
                                                                <img title="Name: {{ $pos22r[0]->name."\n"}}Country: {{$pos22r[0]->country."\n"}}Balance: {{$pos22r[0]->balance."\n"}}" src="{{ asset('assets/images') }}/{{$pos22r[0]->image }}">
                                                                <p class="name">
                                                                    {{$pos22r[0]->username}}
                                                                </p>
                                                            </div></a>
                                                            @else
                                                            <div class="person">
                                                                <img src="{{asset('assets/img/av.png')}}">
                                                                <p class="name">
                                                                    None
                                                                </p>
                                                            </div>
                                                            @endif
                                                        </div>
                                                        <div class="hv-item-children s">
                                                            <div class="hv-item-child">
                                                                @if(count($pos34l) > 0)
                                                                <a href="{{url('backoffice/network/showtrees?id='.$pos34l[0]->username)}}"><div class="person">
                                                                    <img title="Name: {{ $pos34l[0]->name."\n"}}Country: {{$pos34l[0]->country."\n"}}Balance: {{$pos34l[0]->balance."\n"}}" src="{{ asset('assets/images') }}/{{$pos34l[0]->image }}">
                                                                    <p class="name">
                                                                        {{$pos34l[0]->username}}
                                                                    </p>
                                                                </div></a>
                                                                @else
                                                                <div class="person">
                                                                    <img src="{{asset('assets/img/av.png')}}">
                                                                    <p class="name">
                                                                        None
                                                                    </p>
                                                                </div>
                                                                @endif
                                                            </div>
                                                            <div class="hv-item-child">
                                                                @if(count($pos34r) > 0)
                                                                <a href="{{url('backoffice/network/showtrees?id='.$pos34r[0]->username)}}"><div class="person">
                                                                    <img title="Name: {{ $pos34r[0]->name."\n"}}Country: {{$pos34r[0]->country."\n"}}Balance: {{$pos34r[0]->balance."\n"}}" src="{{ asset('assets/images') }}/{{$pos34r[0]->image }}">
                                                                    <p class="name">
                                                                        {{$pos34r[0]->username}}
                                                                    </p>
                                                                </div></a>
                                                                @else
                                                                <div class="person">
                                                                    <img src="{{asset('assets/img/av.png')}}">
                                                                    <p class="name">
                                                                        None
                                                                    </p>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    <script type="text/javascript">
        $('.btn-c').click(function(e){
            var val = $("#s").val();
            if(!val){
               e.preventDefault(); 
            }
        });
        
    </script>
@endsection