@extends('layouts.newfrontend')
@section('style')

   <link rel="stylesheet" href="{{ asset('assets/css/ion.rangeSlider.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/ranger-style.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/ion.rangeSlider.skinFlat.css') }}">
    <style>
       .price-table {
           margin-bottom: 45px;
       }
   </style>
@endsection

@section('content')
    <!--Header section start-->
    <section id="particles-js" class="header-area header-bg" style="background-image: url('{{ asset('assets/images/slider') }}/{{$slider_text->image}}')">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <div class="header-section-wrapper">
                        <div class="header-section-top-part">
                            <div class="text-first slideInLeft">{!!$slider_text->title!!}</div>
                            <p style="font-size: 1.5em;" class=" slideInDown">{!!$slider_text->subtitle!!}</p>
                        </div>
                        <div class="header-section-bottom-part">
                            <div class="domain-search-from">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Header section end-->
    <div class="clearfix"></div>
    <!-- Admin section start -->
    <div class="admin-section slideInRight">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- admin content start -->
                    <div class="admin-content">
                        <!-- admin text start -->
                        <div class="admin-text">
                            <p>Get access to Your account</p>
                        </div>
                        <!-- admin text end -->
                        <!-- admin user start -->
                        <div class="admin-user">
                            <a href="{{url('login')}}"><button type="submit" name="login">sign in</button></a>
                            <a href="{{url('register')}}"><button type="submit" name="register">register now</button></a>
                        </div>
                        <!-- admin user end -->
                    </div>
                    <!-- admin-content end -->
                </div>
            </div>
        </div>
    </div>
    <!-- Admin section end -->

    <div class="clearfix"></div>
    <!-- Circle Section Start -->
    <section  class="circle-section section-padding section-background slideInUp">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-header">
                        <h2>WHAT IS <span> {{ $basic_setting->title }}</span></h2>
                        <p><img src="{{asset('assets/images/logo/icon.png') }}" alt="icon"></p>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach($features as $feature)
                    <div class="col-md-3">
                        <div class="circle-item flipInY">
                            <img src="{{ asset('assets/images/features') }}/{{$feature->photo}}" alt="items">
                            <div class="circle-content">
                                <h6>{{$feature->title}}</h6>
                                <p>{{$feature->description}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Circle Section End -->
<div class="clearfix"></div>

<!--About community Section Start-->
<section class="section-padding sale-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title text-center">
                    <div class="sale-header slideInDown">
                        <h2>about <span> {{ $site_title }} </span></h2>
                    </div>
                    <div class="sale-content">
                         <div class="row">
                            <div class="col-md-6 slideInLeft">
                                <p class="about-community-text">
                                    {!! $page->about_leftText !!}
                                </p>
                            </div>
                            <div class="col-md-6 slideInRight">
                                <p class="about-community-text text-justify">
                                    {!! $page->about_rightText !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--About community Section end-->
<div class="clearfix"></div>
<!--service section start-->
<section class="section-padding service-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title text-center slideInLeft">
                    <div class="section-header">
                        <h2>Our <span> Services </span></h2>
                        <p><img src="{{asset('assets/images/logo/icon.png') }}" alt="icon"></p>
                    </div>
                    <p>{!! $page->service_subtitle !!}</p>
                </div>
            </div>
        </div>
        <div class="row slideInRight">
            @foreach($service as $s)
            <div class="col-md-3 col-sm-6">
                <div class="service-wrapper text-center">
                    <div class="service-icon ">
                        {!! $s->code !!}
                    </div>
                    <div class="service-title">
                        <p>{{ $s->title }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!--service section end-->

<div class="clearfix"></div>
<!-- Sale Section Start -->
<section class="sale-section section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Sale Header Start -->
                <div class="sale-header">
                    <h2>New <span>Customer?</span></h2>
                </div>
                <!-- Sale header End -->
                <!-- Sale Content Start -->
                <div class="sale-content" style="text-align: center;">
                    <a class="btn btn-success" style="padding: 8px 20px;" href="{{ route('how.works') }}">How It Works?</a>
                </div>
                <!-- Sale content end -->
            </div>
        </div>
    </div>
</section>
<!-- Sale Section End -->
<div class="clearfix"></div>
<!--start investment plan-->
<Section class="pricing2-section section-background">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title text-center section-padding padding-bottom-0 slideInLeft">
                    <div class="section-header">
                        <h2>Our awesome<span> plans</span></h2>
                        <p><img src="{{asset('assets/images/logo/icon.png') }}" alt="icon"></p>
                    </div>
                    <p>{!! $page->plan_subtitle !!}</p>
                </div>
            </div>
        </div>
        <!-- Pricing List Start -->
            @if($plan)
                @php $i = 0 @endphp
                @foreach($plan as $key => $package)
                    @php $i++ @endphp
                    @if($i%4 == 1)
                        <br>
                        <div class="row">
                            @endif
                            <div class="col-md-3 col-sm-6">
                                <!-- Pricing  List1 Start -->
                                <div class="pricing-list1 pricing-list2">
                                    <div class="pricing-thumb">
                                        <h3 class="text-center" style="color: #fff;padding-top: 20px;">{{ $package->miner }}</h3>
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
                                    <a href="{{ route('miner', $key) }}">More Plan</a>
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
<!--end start investment plan-->
<div class="clearfix"></div>
@if($partners)
<section class="client-section section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-header zoomInDown">
                    <h2>OUR <span> PARTNER </span></h2>
                    <p><img src="{{asset('assets/images/logo/icon.png') }}" alt="icon"></p>
                </div><!-- section-heading -->
                <div class="section-wrapper">
                    <div class="client-list">
                        <!-- Swiper -->
                        <div class="swiper-container client-container">
                            <div class="swiper-wrapper">
                                @foreach($partners as $partner)
                                    <div class="swiper-slide"><div class="our-client rotateIn"><a href="#"><img class="img-responsive" src="{{ asset('assets/images') }}/{{ $partner->logo }}" alt="{{ $partner->name }}"></a></div></div>
                                @endforeach
                            </div>
                            <!-- Add Arrows -->
                            <div class="swiper-button-next">
                                <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                            </div>
                            <div class="swiper-button-prev">
                                <i class="fa fa-angle-double-left" aria-hidden="true"></i>
                            </div>
                        </div><!-- client container -->
                    </div><!-- client list-->
                </div><!-- swiper wrapper -->
            </div>

        </div><!-- row -->
    </div><!-- container -->
</section>
<div class="clearfix"></div>
@endif
<!--testimonial section start-->
    <section class="people-say-section section-padding section-background">
      <div class="container">
       <div class="row">
        <div class="col-md-12">
          <!-- section header start -->
          <div class="section-header bounceInLeft">
            <h2>What <span>People Say</span>!</h2>
           <p><img src="{{asset('assets/images/logo/icon.png') }}" alt="icon"></p>
          </div>
        <!-- section header end -->
        </div>
      </div>
        <div class="row">
          <div class="col-md-12">   

              <div class="testimonial-area">
                <div class="row">
                    <div class="col-lg-12  col-md-10 ">
                      <div class="row">
                        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-2">
                          <div class="testimonial-image-slider slider-nav text-center">
                          @foreach($testimonial as $tes)    
                            <div class="sin-testiImage rotateIn">
                              <img src="{{ asset('assets/images') }}/{{ $tes->image }}" alt="slider">
                            </div>
                         @endforeach
                          </div>
                        </div>
                  </div>
                      </div> 

                </div>  
                  <div class="row">
                  <div class="col-md-12 ">
                      <div class="testimonial-text-slider slider-for text-center bounceInRight">
                         @foreach($testimonial as $tes)    
                            <div class="sin-testiText">
                                 <!-- people sat content list start -->
                                  <div class="people-say-content-list  " >
                                    <h4>{{ $tes->name }}</h4>

                                    <h6>{{ $tes->position }}</h6>
                                    <ul>
                                        <li>
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                        </li>
                                        <li>
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                        </li>
                                        <li>
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                        </li>
                                        <li>
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                        </li>
                                        <li>
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                        </li>
                                    </ul>
                                    <p>
                                        {!! $tes->message !!} 
                                    </p>
                                  </div>
                                  <!-- people-say-content-list end -->
                            </div>
                     @endforeach    
                        </div> 
                  </div>
                  </div>
                </div>
              </div>

          </div>

        </div><!-- row -->
    </section><!--  section -->
<!--testimonial section start-->
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/ion.rangeSlider.js') }}"></script>
    <script type="text/javascript">
        $(window).load(function() {
            var = new({
                boxClass: ',
                animateClass: 'animated',
                offset: 0,
                mobile: true,
                live: true
            });
           .init();
        });
    </script>
    <script>
        $.each($('.slider-input'), function() {
            var $t = $(this),

                    from = $t.data('from'),
                    to = $t.data('to'),

                    $dailyProfit = $($t.data('dailyprofit')),
                    $totalProfit = $($t.data('totalprofit')),

                    $val = $($t.data('valuetag')),

                    perDay = $t.data('perday'),
                    perYear = $t.data('peryear');


            $t.ionRangeSlider({
                input_values_separator: ";",
                prefix: '{{ $basic->symbol }} ',
                hide_min_max: true,
                force_edges: true,
                onChange: function(val) {
                    $val.val( '{{ $basic->symbol }} ' + val.from);

                    var profit = (val.from * perDay / 100).toFixed(1);
                    profit  = '{{ $basic->symbol }} ' + profit.replace('.', '.') ;
                    $dailyProfit.text(profit) ;

                    profit = ( (val.from * perDay / 100)* perYear ).toFixed(1);
                    profit  =  '{{ $basic->symbol }} ' + profit.replace('.', '.');
                    $totalProfit.text(profit);

                }
            });
        });
        $('.invest-type__profit--val').on('change', function(e) {

            var slider = $($(this).data('slider')).data("ionRangeSlider");

            slider.update({
                from: $(this).val().replace('{{ $basic->symbol }} ', "")
            });
        })
    </script>
@endsection