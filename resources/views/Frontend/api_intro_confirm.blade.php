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
    <section class="banner" role="banner" id="home" style="height: 108px;">
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
                  <li><a href="/api-intro">API</a></li>
                </ul>
              </nav>
              <a href="#" class="nav-toggle">Menu<span></span></a>
            </div>
        </header>

    </section>

    <div class="container">
        <div class="register-col">
            <div class="box box-default" style="display: flex; justify-content: center">

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

                <div class="box-body" style="width: 540px">
                    <h4 style="text-align: center; margin-bottom: 32px; color: white">Confirm to subscription</h4>
                    <p style="color: white">
                        The tuning Data API is a monthly subscription service, that allows access though an API to the European car and LCV tuning database, Stage 1 and Stage 2.<br/>
                        These are just esimated gains for customer guidance and point of sale use on your website. <br/>
                        We will supply you with instructions to forward to your web developer how to integrate in to your website. <br/>
                        The following page will take you to PayPal to start your subscription of £49 per month.
                    </p>
                    <div>
                        <input type="checkbox" id="chktc">
                        <label for="vehicle1">I agree to the <a href="{{ route('frontend.api.tc') }}"> API terms and Conditions</a></label><br>
                    </div>
                    <div style="display: flex; justify-content: center; margin-bottom: 36px">
                        <a id="linkproceed" class="btn btn-default" href="{{ route('frontend.api.sub', ['token' => $token]) }}" disabled>Subscribe</a>
                    </div>
                </div>
            </div>

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
        $(function() {
            $('body').scrollTop(1);
        });
        $('#chktc').change(function (){
            if ($(this).is(':checked')) {
                $('#linkproceed').removeAttr('disabled');
            } else {
                $('#linkproceed').attr('disabled','disabled');
            }

        })
    </script>
    </body>
</html>
