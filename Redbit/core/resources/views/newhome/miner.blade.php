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

    <Section class="pricing2-section section-padding section-background">
        <div class="container">
            <!-- Pricing List Start -->
            @if($plans)
                @php $i = 0 @endphp
                @foreach($plans as $key => $package)
                    @php $i++ @endphp
                    @if($i%4 == 1)
                        <br>
                        <div class="row">
                            @endif
                            <div class="col-md-3 col-sm-6">
                                <!-- Pricing  List1 Start -->
                                <div class="pricing-list1 pricing-list2">
                                    <div class="pricing-thumb">
                                        <i class="fa fa-server" aria-hidden="true"></i>
                                    </div>
                                    <div class="pricing-header1">
                                        <h5>{{ $package->title }}</h5>
                                        <p>{{ $package->speed }}</p>
                                        <p class="text-center" style="text-transform: uppercase;font-size: 12px;color: #fff;">Get {{ $package->return }} {{ $package->category->code }} Per Day For {{ $package->period . ' ' . $package->ptyp }}</p>
                                    </div>
                                    <div class="pricing-amount1"><p>{{ $basic->symbol }}</p><span> {{ $package->price }}</span></div>
                                    <div class="pricing-info1">
                                        <ul>
                                            @if(@unserialize($package->features))
                                                @foreach(@unserialize($package->features) as $feature)
                                                    <li>
                                                        <p>{{ $feature }}</p>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                    <a href="{{ route('plan.purchase', $package->id) }}">Buy Now</a>
                                </div>
                                <!-- Pricing List1 End -->
                            </div>


                            @if($i%4 == 0)
                        </div>
                    @endif
                @endforeach
            @endif
        <!-- Pricing List End -->
        </div>
    </section>
@endsection