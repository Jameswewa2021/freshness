<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Libra Trading - Success Beyond Limits" />
    <title>{{$site_title}}</title>

    <!--font-awesome icons link-->
    <link rel="icon" type="image/png" href="{{asset('assets/user1/images/favicon.png') }}">
    <link rel="stylesheet" href="assets/home/css/font-awesome.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/home/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/home/css/slick.css">
    <link rel="stylesheet" href="assets/home/css/venobox.css">
    <link rel="stylesheet" href="assets/home/css/killercarousel.css">
    <!--main style file-->
    <link rel="stylesheet" href="assets/home/css/style.css">
    <link rel="stylesheet" href="assets/home/css/responsive.css">
</head>

<body id="index2">
    <!-- perloader part start -->
    <div id="main-preloader" class="main-preloader semi-dark-background">
        <div class="main-preloader-inner center">

            <div class="preloader-percentage center">
                <div class="object object_one"></div>
                <div class="object object_two"></div>
                <div class="object object_three"></div>
                <div class="object object_four"></div>
                <div class="object object_five"></div>
            </div>
            <div class="preloader-bar-outer">
                <div class="preloader-bar"></div>
            </div>
        </div>
    </div>
    <!-- perloader part start -->

    <!-- HEADER AREA START -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{url('/')}}"><b>Blue Forex Limited</b></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </button>

            <div class="collapse navbar-collapse menu-main" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto menu-item">
                    <li class="nav-item">
                        <a class="nav-link" href="#banner">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#overview">Feature</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#feature">Trading Assets</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#faq">Why us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>                   
                    @if(Auth::check())
                    <li class="nav-item">
                        <a class="nav-link nav-account" href="{{ route('user-dashboard') }}">Back Office</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link nav-account" href="{{ route('login') }}">Sign In</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-account" href="{{ route('register') }}">Sign Up</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <!-- HEADER AREA END -->

    <!-- BANNER AREA START -->
    <section id="banner">
        <div class=".particles-js-canvas-el" id="particles-js"></div>
        <div class="container zindex2">
            <div class="row">
                <div class="col-lg-5 col-md-6 banner-text">
                    <h2>Welcome</h2>
                    <h3>Success Beyond Limits</h3>
                    <p>Blue Forex Limited most advance and innovative trading platform.We aims to achieve higher goals</p>
                    <a href="{{ route('register') }}">Join Now</a>
                </div>
                <div class="col-lg-7 col-md-6">
                    <div class="banner-img">
                        <div class="circle"></div>
                        <img src="assets/home/images/ch1.png" alt="banner-img" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- BANNER AREA END -->

    <!-- OVERVIEW AREA START -->
    <section id="overview">
        <div class="backtotop">
            <a href="#banner"><i class="fa fa-rocket" aria-hidden="true"></i></a>
        </div>
        <div class="mov-arrow">
            <i class="fa fa-long-arrow-right arrow-right" aria-hidden="true"></i>
            <i class="fa fa-long-arrow-left arrow-left" aria-hidden="true"></i>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center overview-head">
                    <h2>Feature</h2>
                </div>
            </div>
            <div class="row overview-p">
                <div class="col-lg-12">
                    <div class="over-main">
                        <div class="col-lg-6 over-item">
                            <div class="over-shadow">
                                <div class="row">
                                    <div class="col-lg-4 text-center over-i">
                                        <i class="fa fa-cogs" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-lg-8 over-text">
                                        <h3>Easy To Use</h3>
                                        <p>Our Platform is very easy to use no knowledge is required learn in just a few steps</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 over-item">
                            <div class="over-shadow">
                                <div class="row">
                                    <div class="col-lg-4 text-center over-i">
                                        <i class="fa fa-heart" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-lg-8 over-text">
                                        <h3>Support 24/7/365</h3>
                                        <p>We love our customers, we know how to tookcare of them with our support</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 over-item">
                            <div class="over-shadow">
                                <div class="row">
                                    <div class="col-lg-4 text-center over-i">
                                        <i class="fa fa-lock" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-lg-8 over-text">
                                        <h3>Security</h3>
                                        <p>We employ the latest information security standards in the industry, Your investment is safe</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- OVERVIEW AREA END -->

    <!-- Video AREA -->
    <!-- <section id="count">
        <div class="container zindex2">
            <div class="row counter-main">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="counter-1 text-center col-lg-6 col-sm-6 col-md-6">
                            <div class="chart" data-percent="75">
                            </div>
                            <h3>1.5B</h3>
                            <h4>Download</h4>
                        </div>
                        <div class="counter-1 text-center col-lg-6  col-sm-6 col-md-6">
                            <div class="chart" data-percent="65">
                            </div>
                            <h3>4.6</h3>
                            <h4>Rating</h4>
                        </div>
                        <div class="counter-1 text-center col-lg-6 col-sm-6 col-md-6">
                            <div class="chart" data-percent="55">
                            </div>
                            <h3>500M</h3>
                            <h4>Active User</h4>
                        </div>
                        <div class="counter-1 text-center col-lg-6 col-sm-6 col-md-6">
                            <div class="chart" data-percent="45">
                            </div>
                            <h3>13K</h3>
                            <h4>Updates</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <div class="count-i">
                        <a class="venobox" data-autoplay="true" data-vbtype="video" href="https://www.youtube.com/watch?v=nuktTVmoKfc"><i class="fa fa-play" aria-hidden="true"></i></a>
                        <div class="count-btn">
                            <a class="venobox" data-autoplay="true" data-vbtype="video" href="https://www.youtube.com/watch?v=nuktTVmoKfc">Watch Our Story</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <!-- video AREA END -->

    <!-- FEATURE AREA START -->
    <section id="feature">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center overview-head">
                    <h2>Trading Assets</h2>
                </div>
            </div>
            <div class="row f-p">
                <div class="col-lg-6 col-md-10 m-md-auto f-img">
                    <img src="assets/home/images/feature11.png" alt="feature-img" class="img-fluid">
                </div>
                <div class="col-lg-6 f-text">
                    <h2>GET THE BEST,</h2>
                    <h3>Most Profitable Assets</h3>
                    <p class="p-padding">We do trades in 2 higly demanded assets.</p>
                    <p><i class="fa fa-btc" aria-hidden="true"></i> Cryptocurrency Trading</p>
                    <p><i class="fa fa-dollar" aria-hidden="true"></i>
                        Forex Trading</p>
                </div>
            </div>
        </div>
    </section>
    <!-- FEATURE AREA END -->

    <!-- COUNT AREA START -->
    <section id="count">
        <div class="container zindex2">
            <div class="row counter-main">
                <div class="col-lg-6 f-text">
                    <h3>Whats is Forex?</h3>
                    <p class="p-padding text-white">Forex, also known as foreign exchange, FX or currency trading, is a decentralized global market where all the world's currencies trade. The forex market is the largest, most liquid market in the world with an average daily trading volume exceeding $5 trillion.</p>
                    <h3>Whats is Crypto?</h3>
                    <p class="p-padding text-white">Crypto trading, or cryptocurrency trading is simply the exchange of cryptocurrencies. Like in Forex, you can also buy and sell a cryptocurrency for another. Like Bitcoin or altcoin for USD and Euro. This is one way of getting involved in the world of cryptocurrencies without having to mine it.</p>
                </div>
                <div class="col-lg-6 col-md-10 m-md-auto">
                    <img src="assets/home/images/trade.png" alt="banner-img" class="img-fluid">
                </div>
                </div>
            </div>
        </div>
    </section>
    <!-- COUNTER AREA END -->

    <!-- FAQ AREA START -->
    <section id="faq">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center overview-head wh mix-pro">
                    <h2>Why Us?</h2>
                </div>
            </div>
            <div class="row f-p">
                <div class="col-lg-6 f-text2">
                    <div class="pro-text">
                        <h2>NEED MORE INFORMATION?</h2>
                    </div>
                    <div class="accordion" id="accordionExample">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        01. We are Honest.
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    BLUE Forex Limited aims to built a business model that regards honestly a core business value.
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingTwo">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        02. Withdraws on time.
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                <div class="card-body">
                                    We always prioritize our withdraws payout dates.
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingThree">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        03. Easy to invest.
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                <div class="card-body">
                                    We are at the fore front of bringing convenience in the industry of electronic trading and investment. Invest and get paid any where, any time . Watch your passive income sky rocket
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-10 m-md-auto f-img">
                    <img src="assets/home/images/solution.png" alt="feature-img" class="img-fluid">
                </div>
            </div>
        </div>
    </section>
    <!-- FAQ AREA END -->

    <!-- CONTACT AREA START -->
    <section id="contact">
        <div class="container zindex2">
            <div class="row">
                <div class="col-lg-12 text-center overview-head down-oh color-fit wh mix-pro">
                    <h2>CONTACT</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-10 m-auto">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <form>
                                <div class="form-group mix">
                                    <p><i class="fa fa-user" aria-hidden="true"></i>
                                        Your First Name</p>
                                    <input type="text" class="form-control" placeholder="Ex. CMSoft">
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <form>
                                <div class="form-group mix">
                                    <p><i class="fa fa-user" aria-hidden="true"></i>
                                        Your Last Name</p>
                                    <input type="text" class="form-control" placeholder="Ex. Solutions">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row input-pa">
                        <div class="col-lg-12 col-md-12">
                            <form>
                                <div class="form-group mix">
                                    <p><i class="fa fa-envelope" aria-hidden="true"></i>
                                        Your Email Address</p>
                                    <input type="email" class="form-control" placeholder="name@exmple.com">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row input-pa">
                        <div class="col-lg-12 col-md-12">
                            <form>
                                <div class="form-group mix">
                                    <p><i class="fa fa-comments" aria-hidden="true"></i>
                                        Send Us Message</p>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="......."></textarea>
                                </div>
                                <div class="input-btn-pa mix">
                                    <div class="faq-bottom-btn text-center">
                                        <a href="#"><i class="fa fa-paper-plane" aria-hidden="true"></i>
                                            Send Message</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- CONTACT AREA END -->

    <!--  FOOTER AREA START -->
    <section id="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <a class="navbar-brand nb-2" href="index.html"><b>BLUE FOREX Limited</b></a>
                </div>
            </div>
            <div class="row no-p2 pt-5">
                <div class="col-lg-3 col-sm-6 col-md-6 footer-text">
                    <h3>About Us</h3>
                    <p>Blue Forex Limited most advance and innovative trading platform. We aims to achieve higher goals</p>
                </div>
                <div class="col-lg-3 col-sm-6 col-md-6 footer-text">
                    <h3>Our Menu</h3>
                    <a href="#banner">Home</a>
                    <a href="#overview">Feature</a>
                    <a href="#feature">Trading Assets</a>
                    <a href="#faq">Why us</a>
                    <a href="#contact">Contact</a>
                </div>
                <div class="col-lg-3 col-sm-6 col-md-6 footer-text">
                    <h3>Follow Us</h3>
                    <a href="#">Facebook</a>
                    <a href="#">Twitter</a>
                    <a href="#">Google+</a>
                    <a href="#">Youtube</a>
                    <a href="#">Instagram</a>
                </div>
            </div>
        </div>
    </section>
    <!--  FOOTER AREA END -->

    <!--  COPYRIGHT AREA START -->
    <div id="copyright">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center copyright-text">
                    <p>&copy; 2019 {{$site_title}}. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>
    <!--  COPYRIGHT AREA END -->

    <!-- Optional JavaScript -->
    <script src="assets/home/js/jquery-1.12.4.min.js"></script>
    <script src="assets/home/js/bootstrap.min.js"></script>
    <script src="assets/home/js/slick.min.js"></script>
    <script src="assets/home/js/killercarousel.js"></script>
    <script src="assets/home/js/particles.js"></script>
    <script src="assets/home/js/app.js"></script>
    <script src="assets/home/js/venobox.min.js"></script>
    <script src="assets/home/js/circular.js"></script>
    <script src="assets/home/js/custom.js"></script>
</body>
</html>