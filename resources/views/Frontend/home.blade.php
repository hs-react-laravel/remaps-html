<html lang="en" class="js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers no-applicationcache svg inlinesvg smil svgclippaths"><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome Myremap</title>
    <link rel="icon" href="images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="customcss/front/bootstrap.min.css">
    <link rel="stylesheet" href="customcss/front/owl.carousel.min.css">
    <link rel="stylesheet" href="customcss/front/owl.theme.min.css">
    <link rel="stylesheet" href="customcss/front/owl.transitions.css">
    <link rel="stylesheet" href="customcss/front/flexslider.css">
    <link rel="stylesheet" href="customcss/front/jquery.fancybox.css">
    <link rel="stylesheet" href="customcss/front/main.css">
    <link rel="stylesheet" href="customcss/front/responsive.css">
    <link rel="stylesheet" href="customcss/front/font-icon.css">
    <link rel="stylesheet" href="customcss/front/animate.min.css">
    <link rel="stylesheet" type="text/css" href="customcss/front/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/animate.css/3.5.1/animate.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="customjs/front/jquery.contact.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <style type="text/css">.fancybox-margin{margin-right:17px;}</style></head>

    <body>
    <!-- header section -->
    <section class="banner" role="banner" id="home">
      <header id="header" class="fixed">
        <div class="header-content clearfix"> <a class="logo" href="index.html"><img src="customcss/front/images/logo.png" alt="logo"></a>
          <nav class="navigation" role="navigation">
            <ul class="primary-nav">
             <li><a href="#home" class="">Home</a></li>
              <li><a href="#howitworks" class="">How it works</a></li>
              <li><a href="#features" class="">Features</a></li>
              <li><a href="#price" class="active">Price</a></li>
              <li><a href="#about" class="">About</a></li>
            </ul>
          </nav>
          <a href="#" class="nav-toggle">Menu<span></span></a> </div>
      </header>
      <!-- banner text -->

    <div id="first-slider">
        <div id="carousel-example-generic" class="carousel slide carousel-fade">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class=""></li>
                <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                <li data-target="#carousel-example-generic" data-slide-to="2" class="active"></li>
            </ol>
            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <!-- Item 1 -->
                <div class="item slide1">
                    <div class="row"><div class="container">
                        <div class="col-md-9 text-left">
                            <h3 data-animation="animated bounceInDown" class="">High-quality chiptuning files</h3>
                            <h4 data-animation="animated bounceInUp" class="">tested on our own dynamometer test bench</h4>
                         </div>
                    </div></div>
                 </div>
                <!-- Item 2 -->
                <div class="item slide2">
                    <div class="row"><div class="container">
                        <div class="col-md-7 text-left">
                            <h3 data-animation="animated bounceInDown" class="">Global specialist</h3>
                            <h4 data-animation="animated bounceInUp" class="">a worldwide network of chiptuning specialists</h4>
                         </div>
                    </div></div>
                </div>
                <!-- Item 3 -->
                <div class="item slide3 active">
                    <div class="row"><div class="container">
                        <div class="col-md-7 text-left">
                            <h3 data-animation="animated bounceInDown" class="">The best software guarantee</h3>
                            <h4 data-animation="animated bounceInUp" class="animated bounceInUp">we promise to consistently deliver high quality</h4>
                         </div>
                    </div></div>
                </div>
            </div>
            <!-- End Wrapper for slides-->
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <i class="fa fa-angle-left"></i><span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <i class="fa fa-angle-right"></i><span class="sr-only">Next</span>
            </a>
        </div>
    </div>

    </section>

    <section id="howitworks" class="features features-section">
      <div class="container">
        <div class="section-header">
            <h2 class="wow fadeInDown animated">HOW IT WORKS</h2>
        </div>
        <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="serviceBox">
                    <h3 class="title">Select your package</h3>
                    <p class="description">
                        Choose from monthly, yearly payments. Even host on your own domain if you choose.
                    </p>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="serviceBox">
                    <h3 class="title">Enter your basic details</h3>
                    <p class="description">
                        Fill in your company details which prefills your file panel.
                    </p>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="serviceBox">
                    <h3 class="title">Pay</h3>
                    <p class="description">
                        Make your payment and you are up and running in minutes
                    </p>
                </div>
            </div>
        </div>
      </div>
    </section>

    <section id="">

    </section>
    <div class="banner-slider-outer">
        <div class="container">
          <div class="owl-carousel banner-silder">
          @if (!empty($slider))
             @foreach($slider as $slide)
             <div class="">
                 <div class="d-flex align-items-center slider-caption main-slider-item">
                 @if($slide['image'])
                   <div class="img-block">
                       <img class="main-slider-img" src="storage/uploads/logo/{{ $slide['image'] }}" alt="banner">
                   </div>
                 @endif
                   <div class="content-block">
                       <h1>{{ $slide['title'] }}</h1>
                       <p>{{ $slide['description'] }}</p>
                     @if($slide['button_text'])
                       <div class="btn-outer">
                           <a  href="{{ $slide['button_link'] }}" class="view-btn">{{ $slide['button_text'] }}</a>
                       </div>
                     @endif
                   </div>
                 </div>
              </div>
             @endforeach
             @endif

            </div>

        </div>
    </div>

    <section id="features" class="services service-section">
      <div class="container">
        <div class="section-header">
            <h2 class="wow fadeInDown animated">CORE FEATURES <br/>Designed for Remapping Resellers</h2>
            <p class="wow fadeInDown animated">We consulted remapping masters with active slave networks and file service requirements <br/>and built this portal specifically to help the day to day processing of jobs from remapping professionals</p>
        </div>
        <div class="row col-md-10 col-md-offset-1 col-sm-12">
          <div class="col-md-6 col-sm-6 services text-center">
            <img src="customcss/front/images/icon-04.png" alt="customizable">
            <div class="services-content">
              <h5>CUSTOMISABLE</h5>
              <p>Email notifications<br/>
                Choose your currency<br/>
                Colour themes & logo upload<br/>
                Customisable Email Delivery<br/>
                Even Host on your own domain*<br/>
                Mobile Friendly</p>
            </div>
          </div>
          <div class="col-md-6 col-sm-6 services text-center">
            <img src="customcss/front/images/icon-05.png" alt="customizable">
            <div class="services-content">
              <h5>BILLING</h5>
              <p>No "per file charges"<br/>
                PAYG - No contract<br/>
                Automatic client invoicing<br/>
                VAT or not<br/>
                PayPal Payment Handling<br/>
                Easy Reporting</p>
            </div>
          </div>
        </div>
        <div class="row col-md-10 col-md-offset-1 col-sm-12">
            <div class="col-md-6 col-sm-6 services text-center">
                <img src="customcss/front/images/icon-06.png" alt="customizable">
                <div class="services-content">
                    <h5>SUPPORT</h5>
                    <p>Built in ticket support<br/>
                        Chat screen<br/>
                        File attaching<br/>
                        Mobile Support
                    </p>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 services text-center">
                <img src="customcss/front/images/icon-07.png" alt="customizable">
                <div class="services-content">
                    <h5>SECURITY</h5>
                    <p>Secure SSL Encryption<br/>
                        All files are encrypted<br/>
                        2gb of storage included<br/>
                        Extra storage available
                    </p>
                </div>
            </div>
        </div>
      </div>
    </section>

    <section id="price">
        <div id="pricing5" data-section="pricing-5" class="data-section">
            <div class="container">
             <div class="section-header">
                    <h2 class="wow fadeInDown animated">Price</h2>
                    <p class="wow fadeInDown animated">MY REMAPS FILE SERVICE PORTAL</p>
                </div>
                 <div class="row col-md-10 col-md-offset-1">
                     <div class="col-md-6">
                         <div class="table long-table">
                             <h3 class="editContent">Standard Monthly</h3>
                             <h2 class="editContent">£ 49</h2>
                             <p class="editContent">PAYG with this Monthly PayPal Subscription of £49</p>
                             <ul class="table-content">
                                <li class="editContent">Pay us NO commision per file</li>
                                <li class="editContent">Free E commerce shop. (Sell tools)</li>
                                <li class="editContent">Makes Job Mangement Simple</li>
                                <li class="editContent">Designed by tuners for tuners</li>
                                <li class="editContent">Encrypted Secure File Storage</li>
                                <li class="editContent">Your own personal Firewall</li>
                                <li class="editContent">Full featured Remapping File Shop</li>
                                <li class="editContent">Multi Language</li>
                                <li class="editContent">EVC Reseller Official Support</li>
                                <li class="editContent">PayPal and Stripe Credit Handling</li>
                                <li class="editContent">Integrated support ticket system</li>
                                <li class="editContent">Instant messaging to customers</li>
                                <li class="editContent">Email notifications when file is ready</li>
                                <li class="editContent">Automatic invoicing to customers</li>
                                <li class="editContent">Multiple Currencies, Euro, GBP and more</li>
                                <li class="editContent">FREE LISTING ON  MARKETPLACE</li>
                             </ul>

                             <div class="text-center text-uppercase">
                                 <a href="#" class="btn btn-default-blue-tiny editContent">Get Started</a>
                             </div>
                         </div>
                     </div>
                     <div class="col-md-6">
                        <div class="table long-table">
                            <h3 class="editContent">Monthly on own Domain</h3>
                            <h2 class="editContent">£ 59</h2>
                            <p class="editContent">PAYG with this Monthly PayPal Subscription of £59</p>
                            <ul class="table-content">
                                <li class="editContent">Host on your own domain or subdomain.</li>
                                <li class="editContent">Free E commerce to sell tools</li>
                                <li class="editContent">Includes email & web hosting for your main domain</li>
                                <li class="editContent">Pay us NO commision per file processed</li>
                                <li class="editContent">Makes Job Mangement Simple</li>
                                <li class="editContent">Designed by tuners for tuners</li>
                                <li class="editContent">Encrypted Secure File Storage</li>
                                <li class="editContent">Your own personal Firewall</li>
                                <li class="editContent">Full featured Remapping File Shop</li>
                                <li class="editContent">Multi Language</li>
                                <li class="editContent">EVC Reseller Official Support</li>
                                <li class="editContent">PayPal and Stripe Credit Handling</li>
                                <li class="editContent">Integrated support ticket system</li>
                                <li class="editContent">Instant messaging to customers</li>
                                <li class="editContent">Email notifications when file is ready</li>
                                <li class="editContent">Automatic invoicing to customers</li>
                                <li class="editContent">Multiple Currencies, Euro, GBP and more</li>
                                <li class="editContent">FREE LISTING ON  MARKETPLACE</li>
                            </ul>

                            <div class="text-center text-uppercase">
                                <a href="#" class="btn btn-default-blue-tiny editContent">Get Started</a>
                            </div>
                        </div>
                    </div>
                 </div>
            </div>
        </div>

    </section>

    <section id="about" class="content-block data-section nopad content-3-10">
        <div class="image-container col-sm-7 col-xs-12 pull-left">
            <div class="background-image-holder">

            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-5 col-sm-offset-7 col-xs-12 content">
                    <div class="editContent">
                        <h3>About Our Company</h3>
                    </div>
                    <div class="editContent">
                        <p>Remapdash.com is a remapping file comparison site which brings together some of Europe's most experienced tuning companies all under one roof.</p>
                        <p>Discover which tuning company suits your needs and register directly on their file portal. Its Quick, Simple to use and hassle free.</p>
                    </div>
                </div>
            </div><!-- /.row-->
        </div><!-- /.container -->
    </section>

    <section id="testimonials" class="section testimonials">
       <div class="container">
            <div class="row">
                <div class="col-md-offset-3 col-md-6">
                    <div id="testimonial-slider" class="owl-carousel owl-theme" style="opacity: 1; display: block;">
                        <div class="owl-wrapper-outer"><div class="owl-wrapper" style="width: 2220px; left: 0px; display: block; transition: all 0ms ease 0s; transform: translate3d(-555px, 0px, 0px); transform-origin: 832.5px center; perspective-origin: 832.5px center;"><div class="owl-item" style="width: 555px;"><div class="testimonial">
                            <div class="pic">
                                <img src="images/ct-1.jpg" alt="testimonial">
                            </div>
                            <h3 class="testimonial-title">Williamson</h3>
                            <small class="post">Client</small>
                            <p class="description">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam at ornare eros. Proin nec pulvinar augue, at.
                            </p>
                        </div></div><div class="owl-item" style="width: 555px;"><div class="testimonial">
                            <div class="pic">
                                <img src="images/ct-2.jpg" alt="testimonial">
                            </div>
                            <h3 class="testimonial-title">kristiana</h3>
                            <small class="post">Client</small>
                            <p class="description">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam at ornare eros. Proin nec pulvinar augue, at.
                            </p>
                        </div></div></div></div>


                    <div class="owl-controls clickable"><div class="owl-buttons"><div class="owl-prev"></div><div class="owl-next"></div></div></div></div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer_area">
        <div class="container">
            <div class="footer_row row col-md-10 col-md-offset-1 col-sm-12">
                <div class="col-md-6 col-sm-6 footer_about">
                    <h2>ABOUT COMPANY</h2>
                    <p>
                        Remapdash.com is a remapping file comparison site which brings together some of
                        Europe's most experienced tuning companies all under one roof. <br/>
                        Discover which tuning company suits your needs and register directly on their file portal.
                        Its Quick, Simple to use and hassle free.
                    </p>
                </div>
                <div class="col-md-6 col-sm-6 footer_about">
                    <h2>CONTACT US</h2>
                    <address>
                        <p>Have questions, comments or just want to say hello:</p>
                        <ul class="my_address">
                            <li><a href="mailto:sales@remapdash.com"><i class="fa fa-envelope" aria-hidden="true"></i>sales@remapdash.com</a></li>
                            <li><a href="skype:chris-asaprint?chat"><i class="fa fa-skype" aria-hidden="true"></i>chris-asaprint</a></li>
                            <li><a href="https://www.facebook.com/remappingfileportal"><i class="fa fa-facebook" aria-hidden="true"></i>Remapping File Portal</a></li>
                        </ul>
                    </address>
                </div>
            </div>
        </div>
        <div class="copyright_area">
            Copyright © 2023 <a href="#">My Remaps</a>. All Rights Reserved
        </div>
    </footer>
    <!-- Footer section -->
    <!-- JS FILES -->
    <script src="customjs/front/bootstrap.min.js"></script>
    <script src="customjs/front/jquery.flexslider-min.js"></script>
    <script src="customjs/front/jquery.fancybox.pack.js"></script>
    <script src="customjs/front/owl.carousel.min.js"></script>
    <script src="customjs/front/retina.min.js"></script>
    <script src="customjs/front/modernizr.js"></script>
    <script src="customjs/front/main.js"></script>
    <script>
        var owl = $('.banner-silder');
        owl.owlCarousel({
            items:1,
            loop:true,
            autoplayTimeout:5000,
            autoplayHoverPause:true,
            margin:0,
            autoplay:true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        });
    </script>
    </body>
</html>
