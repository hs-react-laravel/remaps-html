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

	<!-- Preloader -->
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
                            <li><a href="#home" class="">Home</a></li>
                            <li><a href="#howitworks" class="">TUNING PORTAL</a></li>
                            <li><a href="#features" class="">Features</a></li>
                            <li><a href="#price">Price</a></li>
                            <li><a href="#about" class="">About</a></li>
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

	<!-- Banner Section -->
	<section class="banner-section" id="home">
		<div class="banner-carousel owl-carousel owl-theme default-navs">
			<!-- Slide Item -->
			<div class="slide-item">
				<div class="bg-image" style="background-image: url(/landing/images/main-slider/1.jpg);"></div>
				<div class="auto-container">
					<div class="content-box">
                        <h1 class="title animate-1">Your own full<br/> featured Remapping<br/> File Portal</h1>
                        <h3 class="animate-1" style="color: white">All for one Low Monthly Price</h3>
					</div>
				</div>
			</div>

			<!-- Slide Item -->
			<div class="slide-item">
				<div class="bg-image" style="background-image: url(/landing/images/main-slider/2.jpg);"></div>
				<div class="auto-container">
					<div class="content-box">
						<h1 class="title animate-1">No Hosting Fees to pay</h1>
                        <h3 class="animate-1" style="color: white">Hosting, maintenance and support fees are Free!</h3>
					</div>
				</div>
			</div>

            <!-- Slide Item -->
			<div class="slide-item">
				<div class="bg-image" style="background-image: url(/landing/images/main-slider/3.jpg);"></div>
				<div class="auto-container">
					<div class="content-box">
						<h1 class="title animate-1">Simple and easy to use!</h1>
                        <h3 class="animate-1" style="color: white">Makes your file service stress free and easy</h3>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Section -->

	<!-- Services Section Two-->
	<section class="services-section-two" id="howitworks">
		<div class="bg bg-pattern-12"></div>

		<div class="auto-container">
			<div class="sec-title text-center light">
				<span class="sub-title">our services</span>
				<h2>HOW IT WORKS</h2>
			</div>

			<div class="row">
				<!-- Service Block Two -->
				<div class="service-block-two col-lg-4 col-md-6 coll-md-12 wow fadeInUp">
					<div class="inner-box">
						<div class="image-box">
							<figure class="image"><img src="{{asset('landing/images/resource/service2-1.jpg')}}" alt=""></figure>
						</div>
						<div class="title-box">
							<h5 class="title"><a href="page-service-details.html">Select<br/> your package</a></h5>
						</div>
						<div class="content-box">
							<i class="icon flaticon-digital-services"></i>
							<div class="text">Choose from monthly, yearly payments</div>
						</div>
					</div>
				</div>

				<!-- Service Block Two -->
				<div class="service-block-two col-lg-4 col-md-6 coll-md-12 wow fadeInUp">
					<div class="inner-box">
						<div class="image-box">
							<figure class="image"><img src="{{asset('landing/images/resource/service2-2.jpg')}}" alt=""></figure>
						</div>
						<div class="title-box">
							<h5 class="title"><a href="page-service-details.html">Enter <br> your basic details</a></h5>
						</div>
						<div class="content-box">
							<i class="icon flaticon-graphic-design"></i>
							<div class="text">Fill in your company details which prefills your file panel</div>
						</div>
					</div>
				</div>

				<!-- Service Block Two -->
				<div class="service-block-two col-lg-4 col-md-6 coll-md-12 wow fadeInUp">
					<div class="inner-box">
						<div class="image-box">
							<figure class="image"><img src="{{asset('landing/images/resource/service2-3.jpg')}}" alt=""></figure>
						</div>
						<div class="title-box">
							<h5 class="title"><a href="page-service-details.html">Pay</a></h5>
						</div>
						<div class="content-box">
							<i class="icon flaticon-technology"></i>
							<div class="text">Make your payment and you are up and running in minutes</div>
						</div>
					</div>
				</div>
			</div>
		</div>
        <div class="banner-slider-outer" style="background: black; margin-top: 20px;">
            <div class="container">
            <div class="owl-carousel banner-silder">
            @if (!empty($slider))
                @foreach($slider as $slide)
                <div class="">
                    <div class="d-flex align-items-center slider-caption main-slider-item">
                    @if($slide['image'])
                    <div class="img-block">
                        <img class="main-slider-img" src="{{ 'https://remapdashforumstore.blob.core.windows.net/'.'uploads/'. $slide['image'] }}" alt="banner">
                    </div>
                    @endif
                    <div class="content-block p-2">
                        <p style="font-size: 28px;">{{ $slide['title'] }}</p>
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
	</section>
	<!--End services-section -->

	<!-- Marquee Section -->
	<div class="marquee-section">
		<div class="marquee">
			<div class="marquee-group">
				<div class="text">*All for one Low Monthly Price</div>
				<div class="text">*Free Hosting, maintenance and support</div>
				<div class="text">*Makes your file service stress free and easy</div>
			</div>

			<div aria-hidden="true" class="marquee-group">
				<div class="text">*All for one Low Monthly Price</div>
				<div class="text">*Free Hosting, maintenance and support</div>
				<div class="text">*Makes your file service stress free and easy</div>
			</div>
		</div>
	</div>
	<!-- End Marquee Section -->

	<!-- About Section Two -->
	<section class="about-section-two" id="about">
		<div class="anim-icons">
			<span class="icon icon-line4"></span>
			<span class="icon icon-line5"></span>
			<span class="icon icon-arrow1 bounce-x"></span>
			<span class="icon icon-speaker zoom-one"></span>
		</div>
		<div class="auto-container">
			<div class="outer-box">
				<div class="row">
					<!-- Content Column -->
					<div class="content-column col-xl-6 col-lg-7 col-md-12 col-sm-12 order-2 wow fadeInRight" data-wow-delay="600ms">
						<div class="inner-column">
							<div class="sec-title">
								<span class="sub-title">About our company</span>
								<h2>Leading the best</h2>
								<div class="text">Remapdash.com is a remapping file comparison site which brings together some of Europe's most experienced tuning companies all under one roof.</div>
                                <div class="text">Discover which tuning company suits your needs and register directly on their file portal. Its Quick, Simple to use and hassle free.</div>
							</div>

							{{-- <div class="row">
								<div class="info-box col-lg-6 col-md-6">
									<div class="inner">
										<h5 class="title"><i class="icon fa fa-circle-arrow-right"></i> Digital marketing</h5>
										<div class="text">Knowledge of technologies rules better than anyone</div>
									</div>
								</div>

								<div class="info-box col-lg-6 col-md-6">
									<div class="inner">
										<h5 class="title"><i class="icon fa fa-circle-arrow-right"></i> Quality results</h5>
										<div class="text">Knowledge of technologies rules better than anyone</div>
									</div>
								</div>
							</div> --}}


							<!--Skills-->
							<div class="skills">
								<!--Skill Item-->
								<div class="skill-item">
									<div class="skill-header">
										<h5 class="skill-title">Marketing</h5>
									</div>
									<div class="skill-bar">
										<div class="bar-inner">
											<div class="bar progress-line" data-width="100">
												<div class="skill-percentage">
													<div class="count-box"><span class="count-text" data-speed="3000" data-stop="100">0</span>%</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							{{-- <div class="bottom-box">
								<a href="page-about.html" class="theme-btn btn-style-one hvr-dark"><span class="btn-title">Discover more</span></a>
							</div> --}}
						</div>
					</div>

					<!-- Image Column -->
					<div class="image-column col-xl-6 col-lg-5 col-md-12 col-sm-12">
						<div class="inner-column wow fadeInLeft">
							<div class="image-box">
								<span class="icon-dots2"></span>
								<figure class="image-1 overlay-anim wow fadeInUp"><img src="{{asset('landing/images/resource/about2-1.jpg')}}" alt=""></figure>
								<figure class="image-2 overlay-anim wow fadeInRight"><img src="{{asset('landing/images/resource/about2-2.jpg')}}" alt=""></figure>
								<div class="exp-box">
									<div class="inner">
										<i class="icon flaticon-promotion"></i>
										<span class="count">50+</span>
										<h6 class="title">Work Experience</h6>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--Emd About Section Two -->

    @php
        $totlPackages = count($packages);
        $classDiv = 'col-md-4';
        if($totlPackages%2 ==0){
            $classDiv = 'col-md-6';
        }
    @endphp

    <section id="price">
        <div id="pricing5" data-section="pricing-5" class="data-section">
            <div class="container">
             <div class="section-header">
                    <h2 class="wow fadeInDown animated">Price</h2>
                    <p class="wow fadeInDown animated">TUNING PORTAL PRICES</p>
                </div>
                 <div class="row col-md-10 col-md-offset-1">
                    @foreach($packages as $val)
					    <div class="@php echo $classDiv @endphp">
                            <div class="table long-table text-center">
                                <h3 class="editContent">{{ $val['name'] }}</h3>
                                <h2 class="editContent">£ {{ $val['amount'] }}</h2>
                                {!! $val['description'] !!}
                                <a href="/register-account?domain={{strpos($val['name'], 'own') !== false ? 'own' : 'regular'}}" class="theme-btn btn-style-one" name="submit-form"><span class="btn-title">Register</span></a>
                            </div>
                        </div>
                    @endforeach
                 </div>
            </div>
        </div>
        <div id="pricing5" data-section="pricing-5" class="data-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="wow fadeInDown animated">Data API</h2>
                </div>
                <div class="row col-md-6 col-md-offset-3">
                    <div class="table long-table text-center">
                        <h3 class="editContent">{{ $apiPackage->name }}</h3>
                        <h2 class="editContent">£ {{ $apiPackage->amount }}</h2>
                        {!! $apiPackage->description !!}
                        <a href="{{ route('frontend.api.intro') }}" class="theme-btn btn-style-one" name="submit-form"><span class="btn-title">Register</span></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

	<!-- Why Choose Us Two -->
	<section class="why-choose-us-two" id="features">
		<div class="anim-icons">
			<span class="icon icon-arrow1"></span>
		</div>

		<div class="auto-container">
			<div class="row">
				<!-- Content Column -->
				<div class="content-column col-lg-6 col-md-12">
					<div class="inner-column wow fadeInRight">
						<div class="sec-title">
							<i class="sub-title">CORE FEATURES</i>
							<h2>Designed for Remapping Resellers</h2>
                            <p>
                                We consulted remapping masters with active slave networks and file service requirements and built this portal specifically to help the day to day processing of jobs from remapping professionals
                            </p>
						</div>
						<div class="row">
							<div class="info-box col-lg-6 col-md-6">
								<div class="inner">
									<div class="title-box">
										<i class="icon flaticon-graphic-design"></i>
										<h5 class="title">CUSTOMISABLE</h5>
									</div>
									<div class="text">
                                        Email notifications<br>
                                        Choose your currency<br>
                                        Colour themes & logo upload<br>
                                        Customisable Email Delivery<br>
                                        Even Host on your own domain*<br>
                                        Mobile Friendly</div>
								</div>
							</div>
							<div class="info-box col-lg-6 col-md-6">
								<div class="inner">
									<div class="title-box">
										<i class="icon flaticon-bank"></i>
										<h5 class="title">BILLING</h5>
									</div>
									<div class="text">
                                        No "per file charges"<br>
                                        PAYG - No contract<br>
                                        Automatic client invoicing<br>
                                        VAT or not<br>
                                        PayPal Payment Handling<br>
                                        Easy Reporting<br>
                                    </div>
								</div>
							</div>
							<div class="info-box col-lg-6 col-md-6">
								<div class="inner">
									<div class="title-box">
										<i class="icon flaticon-health-check"></i>
										<h5 class="title">SUPPORT</h5>
									</div>
									<div class="text">
                                        Built in ticket support
                                        Chat screen
                                        File attaching
                                        Mobile Support
                                    </div>
								</div>
							</div>
							<div class="info-box col-lg-6 col-md-6">
								<div class="inner">
									<div class="title-box">
										<i class="icon flaticon-visitor"></i>
										<h5 class="title">SECURITY</h5>
									</div>
									<div class="text">
                                        Secure SSL Encryption
                                        All files are encrypted
                                        2gb of storage included
                                        Extra storage available
                                    </div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Image Column -->
				<div class="image-column col-lg-6 col-md-12">
					<div class="inner-column">
						<div class="image-box">
							<figure class="image anim-overlay"><img src="{{asset('landing/images/resource/why-us2.jpg')}}" alt=""></figure>
							<div class="content-box">
								<div class="text">Quick, Simple to use and hassle free.</div>
								<div class="caption">Top quality solutions</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Why Choose Us Two -->

	<!-- Testimonial Section Two -->
	<section class="testimonial-section-two">
		<div class="bg bg-pattern-9"></div>
		<div class="auto-container">
			<div class="row">
				<!-- Title Column -->
				<div class="title-column col-xl-3 col-lg-4 col-md-12">
					<div class="inner-column">
						<div class="sec-title">
							<span class="sub-title">testimonials</span>
							<h2>What they’re talking about</h2>
							<div class="text">Lorem ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean solldin, lorem is simply free text quis bibendum.</div>
						</div>
					</div>
				</div>

				<!-- Testimonial Column -->
				<div class="testimonial-column col-xl-9 col-lg-8 col-md-12">
					<div class="inner-column">
						<div class="testimonial-carousel-two owl-carousel default-navs">
							<!-- Testimonial Block -->
							<div class="testimonial-block-two">
								<div class="inner-box">
									<div class="content-box">
										<figure class="thumb"><img src="{{asset('landing/images/resource/testi-thumb-2.jpg')}}" alt=""></figure>
										<div class="rating">
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
										</div>
										<div class="text">Lorem ipsum is simply free text dolor not sit amet, notted adipisicing elit sed do eiusmod incididunt labore et dolore text.</div>
										<div class="info-box">
											<h6 class="name">Sarah albert</h6>
											<span class="designation">Designer</span>
										</div>
									</div>
								</div>
							</div>

							<!-- Testimonial Block -->
							<div class="testimonial-block-two">
								<div class="inner-box">
									<div class="content-box">
										<figure class="thumb"><img src="{{asset('landing/images/resource/testi-thumb-3.jpg')}}" alt=""></figure>
										<div class="rating">
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
										</div>
										<div class="text">Lorem ipsum is simply free text dolor not sit amet, notted adipisicing elit sed do eiusmod incididunt labore et dolore text.</div>
										<div class="info-box">
											<h6 class="name">Mike hardson</h6>
											<span class="designation">Designer</span>
										</div>
									</div>
								</div>
							</div>

							<!-- Testimonial Block -->
							<div class="testimonial-block-two">
								<div class="inner-box">
									<div class="content-box">
										<figure class="thumb"><img src="{{asset('landing/images/resource/testi-thumb-4.jpg')}}" alt=""></figure>
										<div class="rating">
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
										</div>
										<div class="text">Lorem ipsum is simply free text dolor not sit amet, notted adipisicing elit sed do eiusmod incididunt labore et dolore text.</div>
										<div class="info-box">
											<h6 class="name">Aleesha brown</h6>
											<span class="designation">Designer</span>
										</div>
									</div>
								</div>
							</div>

							<!-- Testimonial Block -->
							<div class="testimonial-block-two">
								<div class="inner-box">
									<div class="content-box">
										<figure class="thumb"><img src="{{asset('landing/images/resource/testi-thumb-2.jpg')}}" alt=""></figure>
										<div class="rating">
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
										</div>
										<div class="text">Lorem ipsum is simply free text dolor not sit amet, notted adipisicing elit sed do eiusmod incididunt labore et dolore text.</div>
										<div class="info-box">
											<h6 class="name">Sarah albert</h6>
											<span class="designation">Designer</span>
										</div>
									</div>
								</div>
							</div>

							<!-- Testimonial Block -->
							<div class="testimonial-block-two">
								<div class="inner-box">
									<div class="content-box">
										<figure class="thumb"><img src="{{asset('landing/images/resource/testi-thumb-3.jpg')}}" alt=""></figure>
										<div class="rating">
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
										</div>
										<div class="text">Lorem ipsum is simply free text dolor not sit amet, notted adipisicing elit sed do eiusmod incididunt labore et dolore text.</div>
										<div class="info-box">
											<h6 class="name">Mike hardson</h6>
											<span class="designation">Designer</span>
										</div>
									</div>
								</div>
							</div>

							<!-- Testimonial Block -->
							<div class="testimonial-block-two">
								<div class="inner-box">
									<div class="content-box">
										<figure class="thumb"><img src="{{asset('landing/images/resource/testi-thumb-4.jpg')}}" alt=""></figure>
										<div class="rating">
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
										</div>
										<div class="text">Lorem ipsum is simply free text dolor not sit amet, notted adipisicing elit sed do eiusmod incididunt labore et dolore text.</div>
										<div class="info-box">
											<h6 class="name">Aleesha brown</h6>
											<span class="designation">Designer</span>
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
	<!-- End Testimonial Section Two -->

	<!-- Contact Section Two -->
	<section class="contact-section-two">
		<div class="bg bg-pattern-11"></div>
		<div class="image-box">
			<div class="image"><img src="{{asset('landing/images/resource/contact-img.png')}}" alt=""></div>
			<div class="image-overlay"></div>
		</div>
		<div class="auto-container">
			<div class="row">
				<!-- Form Column -->
				<div class="form-column col-lg-7 col-md-12">
					<div class="inner-column">
						<div class="sec-title light">
							<span class="sub-title">Get in touch</span>
							<h2>Let’s work together</h2>
						</div>

						<!-- Contact Form -->
						<div class="contact-form wow fadeInLeft">
							<!--Contact Form-->
							<form method="post" action="get" id="contact-form">
								<div class="row">
									<div class="form-group col-lg-6 col-md-12 col-sm-12">
										<input type="text" name="full_name" placeholder="Your name" required>
									</div>
									<div class="form-group col-lg-6 col-md-12 col-sm-12">
										<input type="email" name="Email" placeholder="Email address" required>
									</div>
									<div class="form-group col-lg-6 col-md-12 col-sm-12">
										<input type="text" name="phone" placeholder="Phone" required>
									</div>
									<div class="form-group col-lg-6 col-md-12 col-sm-12">
										<input type="text" name="subject" placeholder="Subject" required>
									</div>
									<div class="form-group col-lg-12">
										<textarea name="message" placeholder="Write a message" required></textarea>
									</div>
									<div class="form-group col-lg-12">
										<button class="theme-btn btn-style-one" type="submit" name="submit-form"><span class="btn-title">Send a message</span></button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Contact Section Two -->

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

</div><!-- End Page Wrapper -->

<!-- Scroll To Top -->
<div class="scroll-to-top scroll-to-target" data-target="html"><span class="fa fa-angle-up"></span></div>

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
