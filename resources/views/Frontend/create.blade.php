<html lang="en" class="js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers no-applicationcache svg inlinesvg smil svgclippaths"><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome Remapdash</title>
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
    <link rel="stylesheet" href="https://cdn.bootcss.com/animate.css/3.5.1/animate.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="customjs/front/jquery.contact.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script src="https://kit.fontawesome.com/0daacdc723.js" crossorigin="anonymous"></script>
    <style type="text/css">.fancybox-margin{margin-right:17px;}</style></head>

    <body>
    <!-- header section -->
    <section class="banner" role="banner" id="home" style="height: 142px;">
        <header id="header" class="fixed">
            <div class="header-content clearfix"> <a class="logo" href="/"><img src="customcss/front/images/logo.png" alt="logo"></a>
              <nav class="navigation" role="navigation">
                <ul class="primary-nav">
                 <li><a href="/#home" class="">Home</a></li>
                  <li><a href="/#howitworks" class="">How it works</a></li>
                  <li><a href="/#features" class="">Features</a></li>
                  <li><a href="/#price">Price</a></li>
                  <li><a href="/#about" class="">About</a></li>
                  <li><a href="/compare-prices">Companies</a></li>
                  <li><a href="/api-intro">Data API</a></li>
                </ul>
              </nav>
              <a href="#" class="nav-toggle">Menu<span></span></a>
            </div>
        </header>

    </section>

    <div class="container">
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
                   <a  class="btn btn-primary my-4" href="/">Back</a>
					{!! Form::open(array('route' => ('pay.with.paypal.main'), 'method' => 'POST', 'autocomplete' => "off")) !!}

						<div class="form-group">
						  {!! Form::label('name', 'Company Name') !!}
						  {!! Form::text('name', '', ['class' => 'form-control', 'placeholder'=>'Company Name']) !!}
						</div>

						<div class="form-group">
						  {!! Form::label('main_email_address', 'Email Address') !!}
						  {!! Form::text('main_email_address', '', ['class' => 'form-control', 'placeholder'=>'Email Address']) !!}
						</div>

						<div class="form-group">
						  {!! Form::label('password', 'Password') !!}
						  {!! Form::password('password', ['class' => 'form-control', 'placeholder'=>'Password']) !!}
						</div>

						<div class="form-group">
						  {!! Form::label('password_confirmation', 'Confirm Password') !!}
						  {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder'=>'Confirm Password']) !!}
						</div>

						@if($_GET['domain'] == 'regular')
						<div class="form-group">
						  {!! Form::label('domain_prefix', 'Choose your preferred subdomain (yourname.remapdash.com)') !!}
						  <div style="display: flex">
						  {!! Form::text('domain_prefix', '', ['class' => 'form-control', 'id' => 'domain_prefix', 'placeholder'=>'Eg: yourname']) !!}
						  {!! Form::text('domain_suffix', '.remapdash.com', ['class' => 'form-control', 'readonly' => 'true', 'style' => 'width: 150px;']) !!}
						  </div>
						</div>
						@endif
						@if($_GET['domain'] == 'own')
						<div class="form-group">
							{!! Form::label('own_domain', 'Choose your own domain') !!}
							{!! Form::text('own_domain', '', ['class' => 'form-control', 'id' => 'own_domain', 'placeholder'=>'Full FQDN inc https://']) !!}
							{!! Form::label('domain', 'This allows you to have the portal service appear on your own domain name. for example. https://yourdomain.com (or) subdomain,') !!}
							{!! Form::label('own_domain', 'example https://portal.yourdomain.com, if you already have a company website a subdomain is the best option.') !!}
							{!! Form::label('own_domain', 'In order for this to work our support team will ask for you to make some changes to your DNS records
							to be pointed to our servers') !!}
						</div>
						@endif

						<div class="form-group">
						  {!! Form::label('address_line_1', 'Address line 1') !!}
						  {!! Form::text('address_line_1', '', ['class' => 'form-control', 'placeholder'=>'Address line 1']) !!}
						</div>

						<div class="form-group">
						  {!! Form::label('address_line_2', 'Address line 2') !!}
						  {!! Form::text('address_line_2', '', ['class' => 'form-control', 'placeholder'=>'Address line 2']) !!}
						</div>

						<div class="form-group">
						  {!! Form::label('town', 'Town') !!}
						  {!! Form::text('town', '', ['class' => 'form-control', 'placeholder'=>'Town']) !!}
						</div>

						<div class="form-group">
						  {!! Form::label('country', 'Country') !!}
						  {!! Form::text('country', '', ['class' => 'form-control', 'placeholder'=>'Country']) !!}
						</div>

						<div class="form-group">
						  {!! Form::label('vat_number', 'VAT Number (optional)') !!}
						  {!! Form::text('vat_number', '', ['class' => 'form-control', 'placeholder'=>'VAT Number']) !!}
						</div>

						<div class="form-group">
							@php /*
								{!! Form::hidden('package_id', $packageID) !!}
								{!! Form::hidden('amount', $packageAmount) !!}
							*/ @endphp
							{!! Form::hidden('v2_domain_link', '', ['id' => 'v2_domain_link']) !!}
						</div>

						<div class="form-group">
							<div class="g-recaptcha" data-sitekey="{{env('SITE_KEY')}}" ></div>
						</div>

						<div class="form-group">
							<div id="error"></div>
						</div>
						<button id="btnSubmit" class="btn btn-success view-btn" type="submit">Submit</button>


					{!! Form::close() !!}


                </div>
            </div>
			<p>If you need any help, please contact to <a class="custom-link" href="mailto:support@remapdash.com">support@remapdash.com</a></p>
        </div>
    </div>

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
            autoplayTimeout:1000,
            autoplayHoverPause:true,
            margin:0,
            autoPlay:true,
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
        $(function() {
            $('body').scrollTop(1);
        });
        $('#domain_prefix').change(function (){
            $('#v2_domain_link').val($(this).val() + ".remapdash.com");
        })
    </script>
    </body>
</html>
