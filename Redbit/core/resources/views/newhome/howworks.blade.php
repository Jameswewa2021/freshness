@extends('layouts.newfrontend')
@section('content')

    <!--header section start-->
    <section class="breadcrumb-section" style="background-image: url('{{ asset('assets/images/logo/bb.png') }}')">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- breadcrumb Section Start -->
                    <div class="breadcrumb-content">
                        <h5>{{ $page_title}}</h5>
                    </div>
                    <!-- Breadcrumb section End -->
                </div>
            </div>
        </div>
    </section>

    @if($steps)
        <section class="section-padding about-us-page">
            <div class="container">
                <div class="row">
                @foreach($steps as $step)
                    <div class="col-md-4 col-sm-6" style="text-align: center;">
                        <h4>{{ $step->name }}</h4>
                        <img src="{{ asset('assets/images/' . $step->image) }}" alt="{{ $step->name }}" style="width: 150px;height: 150px;border-radius: 76px;">
                        <p style="font-size: 14px;margin-top: 20px;">
                            {{ $step->description }}
                        </p>
                    </div>
                @endforeach
                </div>
                <div class="row">
                    <div class="col-md-4 col-md-offset-4" style="text-align: center;margin-top: 20px;">
                        <a href="{{ url('user/packages') }}" class="btn btn-success">Start Now</a>
                    </div>
                </div>
            </div>
        </section>
    @endif

@endsection