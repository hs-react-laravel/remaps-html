<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Desix | Digital agency HTML Template | Home Page 02</title>
<!-- Stylesheets -->
<link href="{{ asset('landing/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ asset('landing/css/style.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('customcss/front/owl.carousel.min.css')}}">
{{-- <link rel="stylesheet" href="{{ asset('customcss/front/main.css')}}"> --}}

<link rel="shortcut icon" href="{{asset('landing/images/favicon.png')}}" type="image/x-icon">
<link rel="icon" href="{{asset('landing/images/favicon.png')}}" type="image/x-icon">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

<link href="{{ asset('customcss/front/landing-custom.css')}}" rel="stylesheet">

<!-- Responsive -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script><![endif]-->
<!--[if lt IE 9]><script src="js/respond.js"></script><![endif]-->
</head>
<style>
    .section-header {
        text-align: center;
    }
    .col-md-offset-1 {
        margin-left: 8.33333333%;
    }
    .col-md-offset-3 {
        margin-left: 25%;
    }
    .data-section {
        padding: 80px 0;
    }
    .long-table {
        box-shadow: 0 10px 60px rgba(0, 0, 0, 0.05);
        border: 1px solid #e1e2e7;
        padding: 20px 10px;
    }
</style>
  <body>
    <div class="page-wrapper">
      <div class="preloader"></div>
      <!-- Main Header-->
      <header class="main-header header-style-two">
        <!-- Header Top -->
        <div class="header-top">
          <div class="inner-container">
            <div class="top-left">
              <!-- Info List -->
              <ul class="list-style-one">
                <li><i class="fa fa-envelope"></i> <a href="mailto:sales@remapdash.com">sales@remapdash.com</a></li>
              </ul>
            </div>
          </div>
        </div>
        <!-- Header Top -->

        <div class="header-lower">
          <!-- Main box -->
          <div class="main-box">
            <div class="logo-box">
              <div class="logo">
                            <a class="logo" href="/" style="font-family: daysone; font-size: 28px;">
                                <span style="color: white;">REMAP</span><span style="color: #BB6133;">DASH</span>
                            </a>
                        </div>
            </div>

            <!--Nav Box-->
            <div class="nav-outer">
              <nav class="nav main-menu">
                <ul class="navigation">
                                <li><a href="/#home" class="">Home</a></li>
                                <li><a href="/#howitworks" class="">TUNING PORTAL</a></li>
                                <li><a href="/#features" class="">Features</a></li>
                                <li><a href="/#price">Price</a></li>
                                <li><a href="/#about" class="">About</a></li>
                                <li><a href="/compare-prices">Companies</a></li>
                                <li><a href="/api-intro">Data API</a></li>
                </ul>
              </nav>
              <!-- Main Menu End-->
            </div>

            <div class="outer-box">
              <!-- Header Search -->
              {{-- <button class="ui-btn ui-btn search-btn">
                <span class="icon lnr lnr-icon-search"></span>
              </button> --}}

              <a href="skype:chris-asaprint?chat" class="info-btn">
                <i class="icon fa fa-skype"></i>
                <small>Call Anytime</small>
                chris-asaprint
              </a>
              <!-- Mobile Nav toggler -->
              <div class="mobile-nav-toggler"><span class="icon lnr-icon-bars"></span></div>
            </div>
          </div>
        </div>

        <!-- Mobile Menu  -->
        <div class="mobile-menu">
          <div class="menu-backdrop"></div>

          <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
          <nav class="menu-box">
            <div class="upper-box">
              <div class="nav-logo">
                            <a class="logo" href="/" style="font-family: daysone; font-size: 28px; margin-top: -10px">
                                <span style="color: white;">REMAP</span><span style="color: BB6133;">DASH</span>
                            </a>
                        </div>
              <div class="close-btn"><i class="icon fa fa-times"></i></div>
            </div>

            <ul class="navigation clearfix">
              <!--Keep This Empty / Menu will come through Javascript-->
            </ul>
            <ul class="contact-list-one">
              <li>
                <!-- Contact Info Box -->
                <div class="contact-info-box">
                  <i class="icon lnr-icon-phone-handset"></i>
                  <span class="title">Call Now</span>
                  <a href="tel:+92880098670">+92 (8800) - 98670</a>
                </div>
              </li>
              <li>
                <!-- Contact Info Box -->
                <div class="contact-info-box">
                  <span class="icon lnr-icon-envelope1"></span>
                  <span class="title">Send Email</span>
                  <a href="/cdn-cgi/l/email-protection#c6aea3aab686a5a9abb6a7a8bfe8a5a9ab"><span class="__cf_email__" data-cfemail="58303d3428183b373528393621763b3735">[email&#160;protected]</span></a>
                </div>
              </li>
              <li>
                <!-- Contact Info Box -->
                <div class="contact-info-box">
                  <span class="icon lnr-icon-clock"></span>
                  <span class="title">Send Email</span>
                  Mon - Sat 8:00 - 6:30, Sunday - CLOSED
                </div>
              </li>
            </ul>


            <ul class="social-links">
              <li><a href="#"><i class="fab fa-twitter"></i></a></li>
              <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
              <li><a href="#"><i class="fab fa-pinterest"></i></a></li>
              <li><a href="#"><i class="fab fa-instagram"></i></a></li>
            </ul>
          </nav>
        </div><!-- End Mobile Menu -->

        <!-- Header Search -->
        <div class="search-popup">
          <span class="search-back-drop"></span>
          <button class="close-search"><span class="fa fa-times"></span></button>

          <div class="search-inner">
            <form method="post" action="index.html">
              <div class="form-group">
                <input type="search" name="search-field" value="" placeholder="Search..." required="">
                <button type="submit"><i class="fa fa-search"></i></button>
              </div>
            </form>
          </div>
        </div>
        <!-- End Header Search -->

        <!-- Sticky Header  -->
        <div class="sticky-header">
          <div class="auto-container">
            <div class="inner-container">
              <!--Logo-->
              <div class="logo">
                <a class="logo" href="/" style="font-family: daysone; font-size: 28px;">
                                <span style="color: black;">REMAP</span><span style="color: #BB6133;">DASH</span>
                            </a>
              </div>

              <!--Right Col-->
              <div class="nav-outer">
                <!-- Main Menu -->
                <nav class="main-menu">
                  <div class="navbar-collapse show collapse clearfix">
                    <ul class="navigation clearfix">
                      <!--Keep This Empty / Menu will come through Javascript-->
                    </ul>
                  </div>
                </nav><!-- Main Menu End-->

                <!--Mobile Navigation Toggler-->
                <div class="mobile-nav-toggler"><span class="icon lnr-icon-bars"></span></div>
              </div>
            </div>
          </div>
        </div><!-- End Sticky Menu -->
      </header>
      <!--End Main Header -->

      <!-- section API Intro -->
      <section class="section api-intro">
        <div class="container">
          <div style="height: 72px"></div>
          <div class="register-col">
            <div class="box box-default">
              @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                  <button type="button" class="close" data-dismiss="alert">×</button>
                  <strong>{{ $message }}</strong>
                </div>
              @endif

              @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block">
                  <button type="button" class="close" data-dismiss="alert">×</button>
                  <strong>{{ $message }}</strong>
                </div>
              @endif

				      @if($errors->any())
                <div class="alert alert-danger alert-block">
                  @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                  @endforeach
                </div>
              @endif

              <div class="box-body">
                <h4 class="wow fadeInDown animated" style="color: #fec400">Tuning Data API</h4>
                <p>
                  This API gives you the ability to display before and after Stage 1 and 2
                  expected gains on your website.<br/>

                  Use our Quick Start feature which is a single line of code you insert into your HTML.
                  Colours and text can be customised to suit your theme.<br/>

                  For more experienced developers, use our option JSON API and call the data directly
                  into your own custom built configurator.  Instructions supplied.<br/>

                  <h5 style="color: #fec400">All for a single £{{ $price }} per month subscription, cancel anytime.</h5>
                </p>
                <div class="banner-slider-outer">
                  <div class="container">
                    <div class="owl-carousel banner-silder">
                      <div class="api-carousel-wrapper">
                        <div class="img-block">
                          <img src="customimages/snippet-1.png" alt="banner">
                        </div>
                      </div>
                      <div class="api-carousel-wrapper">
                        <div class="img-block">
                          <img src="customimages/snippet-2.png" alt="banner">
                        </div>
                      </div>
                      <div class="api-carousel-wrapper">
                        <div class="img-block">
                          <img src="customimages/snippet-3.png" alt="banner">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <p>Ready to buy? <a class="btn btn-success view-btn" style="margin-left: 20px;" href="{{ route('frontend.api.reg') }}">Register Now</a></p>
            <p>Already have an account? <a class="btn btn-success view-btn" style="margin-left: 20px;" href="{{ route('frontend.api.login') }}">Login</a></p>
            <p>If you need any help, please contact to <a class="custom-link" href="mailto:support@remapdash.com">support@remapdash.com</a></p>
          </div>
        </div>
      </section>
      <!-- End section API Intro -->

      <!-- Main Footer -->
      <footer class="main-footer">
        <div class="bg bg-pattern-6"></div>
        <!-- Footer Uppper -->
        <div class="footer-upper">
          <div class="auto-container">
            <div class="row">
              <!-- Contact info Block -->
              <div class="contact-info-block col-lg-4 col-md-6">
                <div class="inner">
                  <i class="icon fa fa-skype"></i>
                  <span class="sub-title">Call Anytime</span>
                  <div class="text"><a href="skype:chris-asaprint?chat">chris-asaprint</a></div>
                </div>
              </div>
              <!-- Contact info Block -->
              <div class="contact-info-block col-lg-4 col-md-6">
                <div class="inner">
                  <i class="icon fa fa-envelope"></i>
                  <span class="sub-title">Send Email</span>
                  <div class="text"><a href="mailto:sales@remapdash.com">sales@remapdash.com</a></div>
                </div>
              </div>
              <!-- Contact info Block -->
              <div class="contact-info-block col-lg-4 col-md-6">
                <div class="inner">
                  <i class="icon fa fa-facebook"></i>
                  <span class="sub-title">Social Media</span>
                  <div class="text"><a href="https://www.facebook.com/remappingfileportal">Remapping File Portal</a></div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Widgets Section -->
        <div class="widgets-section">
          <div class="auto-container">
            <div class="row">
              <!-- Footer COlumn -->
              <div class="footer-column col-xl-5 col-lg-4 col-md-12">
                <div class="footer-widget about-widget">
                  <div class="widget-content">
                    <div class="logo">
                                        <a class="logo" href="/" style="font-family: daysone; font-size: 28px;">
                                            <span style="color: white;">REMAP</span><span style="color: #BB6133;">DASH</span>
                                        </a>
                                    </div>
                    <div class="text">Welcome to our agency.</div>
                    <ul class="social-icon-two">
                      <li><a href="skype:chris-asaprint?chat"><i class="fa fa-skype"></i></a></li>
                      <li><a href="mailto:sales@remapdash.com"><i class="fa fa-envelope"></i></a></li>
                      <li><a href="https://www.facebook.com/remappingfileportal"><i class="fa fa-facebook"></i></a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!--  Footer Bottom -->
        <div class="footer-bottom">
          <div class="auto-container">
            <div class="copyright-text">© Copyright 2025 by <a href="#"> Remapdash.com</a></div>
          </div>
        </div>
      </footer>
      <!--End Main Footer -->
    </div> <!-- End Page Wrapper -->
    {{-- <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script> --}}
    <script src="{{ asset('landing/js/jquery.js') }}"></script>
    <script src="{{ asset('landing/js/popper.min.js') }}"></script>
    <script src="{{ asset('landing/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('landing/js/jquery.fancybox.js') }}"></script>
    <script src="{{ asset('landing/js/wow.js') }}"></script>
    <script src="{{ asset('landing/js/appear.js') }}"></script>
    <script src="{{ asset('landing/js/select2.min.js') }}"></script>
    <script src="{{ asset('landing/js/owl.js') }}"></script>
    <script src="{{ asset('landing/js/script.js') }}"></script>
    <script src="{{ asset('customjs/front/owl.carousel.min.js')}}"></script>
    <script>
      var owl = $('.banner-silder');
      owl.owlCarousel({
          items:1,
          loop:true,
          autoplayTimeout:1000,
          autoplayHoverPause:true,
          margin:0,
          autoPlay: true,
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
