@extends('layouts.user-frontend.user-dashboard')

@section('content')
<div class="main-content">
    <div class="main-body">
        <div class="card-heading d-flex a-i-center j-c-between">
            <h4 class="card-heading-title">Presentation</h4>
            <div class="card-heading-breadcrumb">
                <div class="breadcrumb-item"><a href="{!! route('document') !!}">Media</a></div>
                <div class="breadcrumb-item active"><a href="#">Presentation</a></div>
            </div>

        </div>
        <div class="card">
           <div class="card-content">
               <div class="card-body px-0">
                <hr/>
                   <div class="col-12 py-1">
                       <img style="height: 60px;float: left" src="{{ asset('assets/images/icon-pdf.png') }}">
                       <a style="line-height: 50px;font-size:1.5rem" href="{{ asset('assets/doc/redbitforex-en.pdf') }}">Redbitforex-EN</a>
                   </div>
                <hr/>
                   <div class="col-12 py-1">
                       <img style="height: 60px;float: left" src="{{ asset('assets/images/icon-pdf.png') }}">
                       <a style="line-height: 50px;font-size:1.5rem" href="{{ asset('assets/doc/redbitforex-cn.pdf') }}">Redbitforex-CN</a>
                   </div>
                <hr/>
                   <div class="col-12 py-1">
                       <img style="height: 60px;float: left" src="{{ asset('assets/images/icon-pdf.png') }}">
                       <a style="line-height: 50px;font-size:1.5rem" href="{{ asset('assets/doc/redbitforex-vn.pdf') }}">Redbitforex-VN</a>
                   </div>
                 <hr/>
                   <div class="col-12 py-1">
                       <img style="height: 60px;float: left" src="{{ asset('assets/images/icon-pdf.png') }}">
                       <a style="line-height: 50px;font-size:1.5rem" href="{{ asset('assets/doc/redbitforex-my.pdf') }}">Redbitforex-MY</a>
                   </div>
                 <hr/>
                   <div class="col-12 py-1">
                       <img style="height: 60px;float: left" src="{{ asset('assets/images/icon-pdf.png') }}">
                       <a style="line-height: 50px;font-size:1.5rem" href="{{ asset('assets/doc/redbitforex-id.pdf') }}">Redbitforex-ID</a>
                   </div>
                 <hr/>
                   <div class="col-12 py-1">
                       <img style="height: 60px;float: left" src="{{ asset('assets/images/icon-pdf.png') }}">
                       <a style="line-height: 50px;font-size:1.5rem" href="{{ asset('assets/doc/redbitforex-es.pdf') }}">Redbitforex-ES</a>
                   </div>
                 <hr/>
                   <div class="col-12 py-1">
                       <img style="height: 60px;float: left" src="{{ asset('assets/images/icon-pdf.png') }}">
                       <a style="line-height: 50px;font-size:1.5rem" href="{{ asset('assets/doc/redbitforex-br.pdf') }}">Redbitforex-BR</a>
                   </div>
                 <hr/>
               </div>
           </div>
        </div>
    </div>
</div>
@endsection