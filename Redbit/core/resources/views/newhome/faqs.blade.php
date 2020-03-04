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
    <!--faq page content start-->
   <section class="faq-section section-padding section-background">
      <div class="container">
              <div class="row">
          <div class="col-md-12">
             <!-- section header start -->
            <div class="section-header">
              <h3><span>General</span> FAQ</h3>
                 <p><img src="{{asset('assets/images/logo/icon.png') }}" alt="icon"></p>
            </div>
          <!-- section header end -->
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
                <div id="faq">
        <div class="container">
            <div class="faq-content">
                <div class="tab-content">
                    
                    <div role="tabpanel" class="tab-pane fade active in" id="domainsTab">
                        <div class="panel-group accordion" id="accordion4" >
                              @foreach($faqs as $key => $f)
                                <div class="panel panel-default active">
                                    <div class="panel-heading" role="tab">
                                        
                                            <h4 class="panel-title"> <a href="#domainsTabQ{{ $f->id }}" role="button" data-toggle="collapse" data-parent="#accordion4" aria-expanded="false" class="collapsed"> {{ $f->title }} <i class="fa fa-minus"></i> </a></h4> 
                                    </div>
                                    <div id="domainsTabQ{{ $f->id }}" class="panel-collapse collapse" role="tabpanel" aria-expanded="false" style="height: 0px;">
                                        <div class="panel-body">
                                            <p> {!!  $f->description !!}</p>
                                        </div>
                                    </div>
                                </div>
                         @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
          </div>
        </div>
      </div>
    </section> 

@endsection