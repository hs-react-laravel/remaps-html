<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Desix | Digital agency HTML Template | Home Page 02</title>
<!-- Stylesheets -->
<link href="{{ asset('landing/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ asset('landing/css/style.css')}}" rel="stylesheet">

<link rel="shortcut icon" href="{{asset('landing/images/favicon.png')}}" type="image/x-icon">
<link rel="icon" href="{{asset('landing/images/favicon.png')}}" type="image/x-icon">

<!-- Responsive -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script><![endif]-->
<!--[if lt IE 9]><script src="js/respond.js"></script><![endif]-->
</head>

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
						<li><i class="fa fa-envelope"></i> <a href="/cdn-cgi/l/email-protection#8fe1eaeaebe7eae3ffcfece0e2ffeee1f6a1ece0e2"><span class="__cf_email__" data-cfemail="87e9e2e2e3efe2ebf7c7e4e8eaf7e6e9fea9e4e8ea">[email&#160;protected]</span></a></li>
						<li><i class="fa fa-map-marker"></i> 88 Broklyn Golden Street. New York</li>
					</ul>
				</div>
				<div class="top-right">
					<ul class="useful-links">
						<li><a href="#">Help</a></li>
						<li><a href="#">Support</a></li>
						<li><a href="#">Contact</a></li>
					</ul>
					<ul class="social-icon-one">
						<li><a href="#"><span class="fab fa-twitter"></span></a></li>
						<li><a href="#"><span class="fab fa-facebook-square"></span></a></li>
						<li><a href="#"><span class="fab fa-pinterest-p"></span></a></li>
						<li><a href="#"><span class="fab fa-instagram"></span></a></li>
					</ul>
				</div>
			</div>
		</div>
		<!-- Header Top -->

		<div class="header-lower">
			<!-- Main box -->
			<div class="main-box">
				<div class="logo-box">
					<div class="logo"><a href="index.html"><img src="{{asset('landing/images/logo.png')}}" alt="" title="Tronis"></a></div>
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
					<button class="ui-btn ui-btn search-btn">
						<span class="icon lnr lnr-icon-search"></span>
					</button>

					<a href="tel:+92(8800)9806" class="info-btn">
						<i class="icon lnr-icon-phone-handset"></i>
						<small>Call Anytime</small>
						+92 (8800) - 9850
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
					<div class="nav-logo"><a href="index.html"><img src="{{asset('landing/images/logo.png')}}" alt="" title=""></a></div>
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
						<a href="index.html" title=""><img src="{{asset('landing/images/logo-2.png')}}" alt="" title=""></a>
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
	<section class="banner-section">
		<div class="banner-carousel owl-carousel owl-theme default-navs">
			<!-- Slide Item -->
			<div class="slide-item">
				<div class="bg-image" style="background-image: url(/landing/images/main-slider/2.jpg);"></div>
				<div class="auto-container">
					<div class="content-box">
						<h3 data-animation="animated bounceInDown" class="">Your own full featured Remapping File Portal</h3>
						<h4 data-animation="animated bounceInUp" class="">All for one Low Monthly Price</h4>
					</div>
				</div>
			</div>

			<!-- Slide Item -->
			<div class="slide-item">
				<div class="bg-image" style="background-image: url(/landing/images/main-slider/2.jpg);"></div>
				<div class="auto-container">
					<div class="content-box">
						<h1 class="title animate-1">Shaping the <br>Perfect Solution <br>for your business</h1>
						<div class="btn-box animate-2">
							<a href="page-about.html" class="theme-btn btn-style-one hover-light"><span class="btn-title">Discover more</span></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Section -->

	<!-- Services Section Two-->
	<section class="services-section-two">
		<div class="bg bg-pattern-12"></div>

		<div class="auto-container">
			<div class="sec-title text-center light">
				<span class="sub-title">our services</span>
				<h2>Explore what services <br>we’re offering</h2>
			</div>

			<div class="row">
				<!-- Service Block Two -->
				<div class="service-block-two col-lg-4 col-md-6 coll-md-12 wow fadeInUp">
					<div class="inner-box">
						<div class="image-box">
							<figure class="image"><img src="{{asset('landing/images/resource/service2-1.jpg')}}" alt=""></figure>
						</div>
						<div class="title-box">
							<h5 class="title"><a href="page-service-details.html">Website <br>Development</a></h5>
						</div>
						<div class="content-box">
							<i class="icon flaticon-digital-services"></i>
							<div class="text">Digital agency is an high test for business website work</div>
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
							<h5 class="title"><a href="page-service-details.html">Graphic <br>designing</a></h5>
						</div>
						<div class="content-box">
							<i class="icon flaticon-graphic-design"></i>
							<div class="text">Digital agency is an high test for business website work</div>
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
							<h5 class="title"><a href="page-service-details.html">Digital <br>marketing</a></h5>
						</div>
						<div class="content-box">
							<i class="icon flaticon-technology"></i>
							<div class="text">Digital agency is an high test for business website work</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--End services-section -->

	<!-- Marquee Section -->
	<div class="marquee-section">
		<div class="marquee">
			<div class="marquee-group">
				<div class="text">*Transofrm ideas into reality</div>
				<div class="text">*INSPIRED WITH CREATIVITY</div>
				<div class="text">*Design & development craft</div>
				<div class="text">*unlock the potential</div>
				<div class="text">*Transofrm ideas into reality</div>
			</div>

			<div aria-hidden="true" class="marquee-group">
				<div class="text">*Transofrm ideas into reality</div>
				<div class="text">*INSPIRED WITH CREATIVITY</div>
				<div class="text">*Design & development craft</div>
				<div class="text">*unlock the potential</div>
				<div class="text">*Transofrm ideas into reality</div>
			</div>
		</div>
	</div>
	<!-- End Marquee Section -->

	<!-- About Section Two -->
	<section class="about-section-two">
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
								<span class="sub-title">Welcome to Agency</span>
								<h2>Leading the best digital agency in town</h2>
								<div class="text">There are many variations of simply free text passages of available but the majority have suffered alteration in some form, by injected hum randomised words which don't slightly.</div>
							</div>

							<div class="row">
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
							</div>


							<!--Skills-->
							<div class="skills">
								<!--Skill Item-->
								<div class="skill-item">
									<div class="skill-header">
										<h5 class="skill-title">Marketing</h5>
									</div>
									<div class="skill-bar">
										<div class="bar-inner">
											<div class="bar progress-line" data-width="77">
												<div class="skill-percentage">
													<div class="count-box"><span class="count-text" data-speed="3000" data-stop="77">0</span>%</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="bottom-box">
								<a href="page-about.html" class="theme-btn btn-style-one hvr-dark"><span class="btn-title">Discover more</span></a>
							</div>
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
										<span class="count">38+</span>
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

	<!-- Projects Section -->
	<section class="projects-section pt-0">
		<div class="auto-container">
			<div class="sec-title text-center">
				<span class="sub-title">our portfolio</span>
				<h2>Explore our new recently <br>completed projects.</h2>
			</div>

			<div class="outer-box">
				<div class="row">
					<!-- Project Block -->
					<div class=" project-block col-lg-3 col-md-6 col-sm-12 wow fadeInUp">
						<div class="inner-box">
							<div class="image-box">
								<figure class="image"><a href="page-project-details.html"><img src="{{asset('landing/images/resource/project-1.jpg')}}" alt=""></a></figure>
							</div>
							<div class="content-box">
								<a href="page-project-details.html" class="icon"><i class="fa fa-long-arrow-alt-right"></i></a>
								<span class="cat">Development</span>
								<h4 class="title"><a href="page-project-details.html" title="">Marketing webdesign</a></h4>
							</div>
						</div>
					</div>

					<!-- Project Block -->
					<div class=" project-block col-lg-3 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="300ms">
						<div class="inner-box">
							<div class="image-box">
								<figure class="image"><a href="page-project-details.html"><img src="{{asset('landing/images/resource/project-2.jpg')}}" alt=""></a></figure>
							</div>
							<div class="content-box">
								<a href="page-project-details.html" class="icon"><i class="fa fa-long-arrow-alt-right"></i></a>
								<span class="cat">Development</span>
								<h4 class="title"><a href="page-project-details.html" title="">Marketing webdesign</a></h4>
							</div>
						</div>
					</div>

					<!-- Project Block -->
					<div class=" project-block col-lg-3 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="600ms">
						<div class="inner-box">
							<div class="image-box">
								<figure class="image"><a href="page-project-details.html"><img src="{{asset('landing/images/resource/project-3.jpg')}}" alt=""></a></figure>
							</div>
							<div class="content-box">
								<a href="page-project-details.html" class="icon"><i class="fa fa-long-arrow-alt-right"></i></a>
								<span class="cat">Development</span>
								<h4 class="title"><a href="page-project-details.html" title="">Marketing webdesign</a></h4>
							</div>
						</div>
					</div>

					<!-- Project Block -->
					<div class=" project-block col-lg-3 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="900ms">
						<div class="inner-box">
							<div class="image-box">
								<figure class="image"><a href="page-project-details.html"><img src="{{asset('landing/images/resource/project-4.jpg')}}" alt=""></a></figure>
							</div>
							<div class="content-box">
								<a href="page-project-details.html" class="icon"><i class="fa fa-long-arrow-alt-right"></i></a>
								<span class="cat">Development</span>
								<h4 class="title"><a href="page-project-details.html" title="">Marketing webdesign</a></h4>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--End projects-section-->

	<!-- Why Choose Us Two -->
	<section class="why-choose-us-two">
		<div class="anim-icons">
			<span class="icon icon-arrow1"></span>
		</div>

		<div class="auto-container">
			<div class="row">
				<!-- Content Column -->
				<div class="content-column col-lg-6 col-md-12">
					<div class="inner-column wow fadeInRight">
						<div class="sec-title">
							<i class="sub-title">Why choose us</i>
							<h2>Building a design easy for business</h2>
						</div>
						<div class="row">
							<div class="info-box col-lg-6 col-md-6">
								<div class="inner">
									<div class="title-box">
										<i class="icon flaticon-laptop"></i>
										<h5 class="title">Web <br>growths</h5>
									</div>
									<div class="text">Good knowledge becuase you done something many times.</div>
								</div>
							</div>
							<div class="info-box col-lg-6 col-md-6">
								<div class="inner">
									<div class="title-box">
										<i class="icon flaticon-graphic-design"></i>
										<h5 class="title">Digital <br>solutions</h5>
									</div>
									<div class="text">Good knowledge becuase you done something many times.</div>
								</div>
							</div>
							<div class="info-box col-lg-6 col-md-6">
								<div class="inner">
									<div class="title-box">
										<i class="icon flaticon-health-check"></i>
										<h5 class="title">Best <br>consultancy</h5>
									</div>
									<div class="text">Good knowledge becuase you done something many times.</div>
								</div>
							</div>
							<div class="info-box col-lg-6 col-md-6">
								<div class="inner">
									<div class="title-box">
										<i class="icon flaticon-teaching"></i>
										<h5 class="title">Expert <br>developers</h5>
									</div>
									<div class="text">Good knowledge becuase you done something many times.</div>
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
								<div class="text">We’re bringing latest business innovation in to the digital world</div>
								<div class="caption">Top quality marketing solutions</div>
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

	 <!-- Team Section -->
	<section class="team-section pb-0">
		<div class="auto-container">
			<div class="sec-title text-center">
				<span class="sub-title">meet our team members</span>
				<h2>Meet the professional team <br>behind the success</h2>
			</div>

			<div class="row">
				<!-- Team block -->
				<div class="team-block-two col-lg-4 col-md-6 col-sm-12 wow fadeInUp">
					<div class="inner-box">
						<div class="info-box">
							<h4 class="name"><a href="page-team-details.html">Mike hardson</a></h4>
							<span class="designation">designer</span>
						</div>
						<div class="image-box">
							<figure class="image"><a href="#"><img src="{{asset('landing/images/resource/team-1.jpg')}}" alt=""></a></figure>
							<div class="social-links">
								<a href="#"><i class="fab fa-twitter"></i></a>
								<a href="#"><i class="fab fa-facebook-f"></i></a>
								<a href="#"><i class="fab fa-pinterest-p"></i></a>
								<a href="#"><i class="fab fa-instagram"></i></a>
							</div>
							<span class="share-icon fa fa-share-alt"></span>
						</div>
					</div>
				</div>

				<!-- Team block -->
				<div class="team-block-two col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="400ms">
					<div class="inner-box">
						<div class="info-box">
							<h4 class="name"><a href="page-team-details.html">Kevin martin</a></h4>
							<span class="designation">designer</span>
						</div>
						<div class="image-box">
							<figure class="image"><a href="#"><img src="{{asset('landing/images/resource/team-2.jpg')}}" alt=""></a></figure>
							<div class="social-links">
								<a href="#"><i class="fab fa-twitter"></i></a>
								<a href="#"><i class="fab fa-facebook-f"></i></a>
								<a href="#"><i class="fab fa-pinterest-p"></i></a>
								<a href="#"><i class="fab fa-instagram"></i></a>
							</div>
							<span class="share-icon fa fa-plus"></span>
						</div>
					</div>
				</div>

				<!-- Team block -->
				<div class="team-block-two col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="800ms">
					<div class="inner-box">
						<div class="info-box">
							<h4 class="name"><a href="page-team-details.html">Christine eve</a></h4>
							<span class="designation">designer</span>
						</div>
						<div class="image-box">
							<figure class="image"><a href="#"><img src="{{asset('landing/images/resource/team-3.jpg')}}" alt=""></a></figure>
							<div class="social-links">
								<a href="#"><i class="fab fa-twitter"></i></a>
								<a href="#"><i class="fab fa-facebook-f"></i></a>
								<a href="#"><i class="fab fa-pinterest-p"></i></a>
								<a href="#"><i class="fab fa-instagram"></i></a>
							</div>
							<span class="share-icon fa fa-plus"></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Team Section -->

	<!-- Clients Section -->
	<section class="clients-section">
		<div class="auto-container">
			<!-- Sponsors Outer -->
			<div class="sponsors-outer">
				<!--clients carousel-->
				<ul class="clients-carousel owl-carousel owl-theme">
					<li class="client-block"> <a href="#"><img src="{{asset('landing/images/clients/1.png')}}" alt=""></a> </li>
					<li class="client-block"> <a href="#"><img src="{{asset('landing/images/clients/1.png')}}" alt=""></a> </li>
					<li class="client-block"> <a href="#"><img src="{{asset('landing/images/clients/1.png')}}" alt=""></a> </li>
					<li class="client-block"> <a href="#"><img src="{{asset('landing/images/clients/1.png')}}" alt=""></a> </li>
					<li class="client-block"> <a href="#"><img src="{{asset('landing/images/clients/1.png')}}" alt=""></a> </li>
				</ul>
			</div>
		</div>
	</section>
	<!--End Clients Section -->

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

	 <!-- News Section Two -->
	<section class="news-section">
		<div class="auto-container">
			<div class="sec-title text-center">
				<span class="sub-title">From the Blog</span>
				<h2>Checkout latest news <br> updates & articles</h2>
			</div>

			<div class="row">
				<!-- News Block -->
				<div class="news-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp">
					<div class="inner-box">
						<div class="image-box">
							<figure class="image"><a href="#"><img src="{{asset('landing/images/resource/news-1.jpg')}}" alt=""></a></figure>
						</div>
						<div class="content-box">
							<span class="date">20 April</span>
							<ul class="post-info">
								<li><i class="fa fa-user-circle"></i> by Admin</li>
								<li><i class="fa fa-comments"></i> 2 Comments</li>
							</ul>
							<h4 class="title"><a href="#">Five ways that can develop your business website</a></h4>
							<a href="#" class="read-more">Read More <i class="fa fa-long-arrow-alt-right"></i></a>
						</div>
					</div>
				</div>

				<!-- News Block -->
				<div class="news-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="300ms">
					<div class="inner-box">
						<div class="image-box">
							<figure class="image"><a href="#"><img src="{{asset('landing/images/resource/news-2.jpg')}}" alt=""></a></figure>
						</div>
						<div class="content-box">
							<span class="date">20 April</span>
							<ul class="post-info">
								<li><i class="fa fa-user-circle"></i> by Admin</li>
								<li><i class="fa fa-comments"></i> 2 Comments</li>
							</ul>
							<h4 class="title"><a href="#">Five ways that can develop your business website</a></h4>
							<a href="#" class="read-more">Read More <i class="fa fa-long-arrow-alt-right"></i></a>
						</div>
					</div>
				</div>

				<!-- News Block -->
				<div class="news-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp">
					<div class="inner-box">
						<div class="image-box">
							<figure class="image"><a href="#"><img src="{{asset('landing/images/resource/news-3.jpg')}}" alt=""></a></figure>
						</div>
						<div class="content-box">
							<span class="date">20 April</span>
							<ul class="post-info">
								<li><i class="fa fa-user-circle"></i> by Admin</li>
								<li><i class="fa fa-comments"></i> 2 Comments</li>
							</ul>
							<h4 class="title"><a href="#">Five ways that can develop your business website</a></h4>
							<a href="#" class="read-more">Read More <i class="fa fa-long-arrow-alt-right"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--End News Section -->

	<!-- Map Section-->
	<section class="map-section">
		<iframe class="map"
			src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=1%20Grafton%20Street,%20Dublin,%20Ireland+(My%20Business%20Name)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed">
		</iframe>
	</section>
	<!--End Map Section-->

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
							<i class="icon fa fa-phone-square"></i>
							<span class="sub-title">Call Anytime</span>
							<div class="text"><a href="tel:+92(8800)48720">+92 (8800) -89 8630</a></div>
						</div>
					</div>
					<!-- Contact info Block -->
					<div class="contact-info-block col-lg-4 col-md-6">
						<div class="inner">
							<i class="icon fa fa-envelope"></i>
							<span class="sub-title">Send Email</span>
							<div class="text"><a href="/cdn-cgi/l/email-protection#dab4bfbfbeb2bfb6aa9ab9b5b7aabbb4a3f4b9b5b7"><span class="__cf_email__" data-cfemail="422c2727262a272e3202212d2f32232c3b6c212d2f">[email&#160;protected]</span></a></div>
						</div>
					</div>
					<!-- Contact info Block -->
					<div class="contact-info-block col-lg-4 col-md-6">
						<div class="inner">
							<i class="icon fa fa-map-marker"></i>
							<span class="sub-title">Addres</span>
							<div class="text">30 Broklyn Golden Street. USA</div>
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
								<div class="logo"><a href="#"> <img src="{{asset('landing/images/logo.png')}}" alt=""></a></div>
								<div class="text">Welcome to our digital agency. Lorem ipsum simply free text dolor sited amet cons cing elit.</div>
								<ul class="social-icon-two">
									<li><a href="#"><i class="fab fa-twitter"></i></a></li>
									<li><a href="#"><i class="fab fa-facebook"></i></a></li>
									<li><a href="#"><i class="fab fa-pinterest"></i></a></li>
									<li><a href="#"><i class="fab fa-instagram"></i></a></li>
								</ul>
							</div>
						</div>
					</div>

					<!-- Footer COlumn -->
					<div class="footer-column col-xl-4 col-lg-4 col-md-6">
						<div class="widget links-widget">
							<h5 class="widget-title">Explore</h5>
							<div class="widget-content">
								<ul class="user-links two-column">
									<li><a href="#">Meet Our Team</a></li>
									<li><a href="#">About</a></li>
									<li><a href="#">What We Do</a></li>
									<li><a href="#">Support</a></li>
									<li><a href="#">Latest News</a></li>
									<li><a href="#">New Projects</a></li>
									<li><a href="#">Contact</a></li>
									<li><a href="#">Shop</a></li>
									<li><a href="#">Faqs</a></li>
								</ul>
							</div>
						</div>
					</div>

					<!-- Footer COlumn -->
					<div class="footer-column col-xl-3 col-lg-4 col-md-6 col-sm-12">
						<div class="widget newsletter-widget">
							<h5 class="widget-title">Newsletter</h5>
							<div class="widget-content">
								<div class="text">Subsrcibe for our latest resources</div>
								<div class="subscribe-form">
									<form method="post" action="#">
										<div class="form-group">
											<input type="email" name="email" class="email" value="" placeholder="Email Address" required="">
										</div>
										<div class="form-group">
											<button type="button" class="theme-btn btn-style-one hover-light"><span class="btn-title">Subscribe</span></button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!--  Footer Bottom -->
		<div class="footer-bottom">
			<div class="auto-container">
				<div class="copyright-text">© Copyright 2024 by <a href="#"> Company.com</a></div>
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
</body>
</html>
