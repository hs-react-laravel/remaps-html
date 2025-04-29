<html lang="en" class="js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers no-applicationcache svg inlinesvg smil svgclippaths">
    <head>
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
        <style type="text/css">
            .fancybox-margin{margin-right:17px;}
            .card {
                border: 1px solid #ffffff26;
                border-radius: 6px;
            }
            .card-header {
                padding: 8px 16px;
                border-radius: 5px 5px 0 0;
                border-bottom: 1px solid #ffffff26;
            }
            .card-header h5 {
                color: white;
            }
            .card-body {
                padding: 16px;
            }
        </style>
    </head>
    <body data-bs-theme="dark">
    <!-- header section -->
    <section class="banner" role="banner" id="home" style="height: 108px;">
        <header id="header" class="fixed">
            <div class="header-content clearfix"> <a class="logo" href="/" style="font-family: daysone; font-size: 28px; margin-top: -10px">
                <span style="color: white;">REMAP</span><span style="color: BB6133;">DASH</span>
            </a>
              <nav class="navigation" role="navigation">
                <ul class="primary-nav">
                 <li><a href="/#home" class="">Home</a></li>
                  <li><a href="/#howitworks" class="">TUNING PORTAL</a></li>
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
                   <div class="footer_about">
                        <h4 style="color:white" class="mt-md-5 mb-4"><i class="fa-solid fa-plug"></i></i>  Rest API</h4>
                        <h5 style="color:white; padding-top: 12px">API Base URL</h5>
                        <p>
                            All api endpoints must be prefixed with the api base url.
                            <pre>https://remapdash.com/api/*</pre>
                        </p>
                        <h5 style="color:white; padding-top: 12px">Authentication</h5>
                        <p>
                            When you make API calls, replace ACCESS-TOKEN with your access token in the authorization header
                            <span class="badge">-H Authorization: Bearer ACCESS-TOKEN</span>.
                        </p>
                        <h5 style="color:white; padding-top: 12px">Standard API Calls</h5>

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0" style="text-transform: none"><span class="badge text-info bg-info-subtle border border-info">GET</span> /makes</h5>
                                <p>List All Makes</p>
                            </div>
                            <div class="card-body">
                                <p>Request</p>
                                <hr>
                                <p>Response <span class="badge">application/json</span></p>
<pre>
[
    {
        "id": 1,
        "make": "Alfa Romeo",
        "logo": "http://localhost:8080/images/carlogo/alfa-romeo.jpg"
    },
    ...
]
</pre>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0" style="text-transform: none"><span class="badge text-info bg-info-subtle border border-info">GET</span> /make/{makeid}</h5>
                                <p>View a Make</p>
                            </div>
                            <div class="card-body">
                                <p>Request</p>
                                <p><span class="badge">makeid</span>&nbsp;: &nbsp;&nbsp;integer</p>
                                <hr>
                                <p>Response <span class="badge">application/json</span></p>
<pre>
{
    "id": 1,
    "make": "Alfa Romeo",
    "logo": "http://localhost:8080/images/carlogo/alfa-romeo.jpg"
}
</pre>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0" style="text-transform: none"><span class="badge text-info bg-info-subtle border border-info">GET</span> /make/{makeid}/models</h5>
                                <p>List all Models of a Make</p>
                            </div>
                            <div class="card-body">
                                <p>Request</p>
                                <p><span class="badge">makeid</span>&nbsp;: &nbsp;&nbsp;integer</p>
                                <hr>
                                <p>Response <span class="badge">application/json</span></p>
<pre>
[
    {
        "id": 1,
        "make": "Alfa Romeo",
        "model": "147"
    },
    ...
]
</pre>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0" style="text-transform: none"><span class="badge text-info bg-info-subtle border border-info">GET</span> /model/{modelid}</h5>
                                <p>View a Model</p>
                            </div>
                            <div class="card-body">
                                <p>Request</p>
                                <p><span class="badge">modelid</span>&nbsp;: &nbsp;&nbsp;integer</p>
                                <hr>
                                <p>Response <span class="badge">application/json</span></p>
<pre>
{
    "id": 1,
    "make": "Alfa Romeo",
    "model": "147"
}
</pre>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0" style="text-transform: none"><span class="badge text-info bg-info-subtle border border-info">GET</span> /model/{modelid}/generations</h5>
                                <p>List all generations of a Model</p>
                            </div>
                            <div class="card-body">
                                <p>Request</p>
                                <p><span class="badge">modelid</span>&nbsp;: &nbsp;&nbsp;integer</p>
                                <hr>
                                <p>Response <span class="badge">application/json</span></p>
<pre>
[
    {
        "id": 1,
        "make": "Alfa Romeo",
        "model": "147",
        "generation": "2001  2005"
    },
    ...
]
</pre>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0" style="text-transform: none"><span class="badge text-info bg-info-subtle border border-info">GET</span> /generation/{generationid}</h5>
                                <p>View a Generation</p>
                            </div>
                            <div class="card-body">
                                <p>Request</p>
                                <p><span class="badge">generationid</span>&nbsp;: &nbsp;&nbsp;integer</p>
                                <hr>
                                <p>Response <span class="badge">application/json</span></p>
<pre>
{
    "id": 1,
    "make": "Alfa Romeo",
    "model": "147",
    "generation": "2001  2005"
}
</pre>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0" style="text-transform: none"><span class="badge text-info bg-info-subtle border border-info">GET</span> /generation/{generationid}/engines</h5>
                                <p>List all Engine types of a Generation</p>
                            </div>
                            <div class="card-body">
                                <p>Request</p>
                                <p><span class="badge">generationid</span>&nbsp;: &nbsp;&nbsp;integer</p>
                                <hr>
                                <p>Response <span class="badge">application/json</span></p>
<pre>
[
    {
        "id": 1,
        "make": "Alfa Romeo",
        "model": "147",
        "generation": "2001  2005",
        "engine": "2.0  TS",
        "std_bhp": "150 hp",
        "tuned_bhp": "165 hp",
        "tuned_bhp_2": null,
        "std_torque": "172 Nm",
        "tuned_torque": "192 Nm",
        "tuned_torque_2": null
    },
    ...
]
</pre>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0" style="text-transform: none"><span class="badge text-info bg-info-subtle border border-info">GET</span> /engine/{engineid}</h5>
                                <p>View details of a Engine</p>
                            </div>
                            <div class="card-body">
                                <p>Request</p>
                                <p><span class="badge">engineid</span>&nbsp;: &nbsp;&nbsp;integer</p>
                                <hr>
                                <p>Response <span class="badge">application/json</span></p>
<pre>
{
    "id": 1,
    "make": "Alfa Romeo",
    "model": "147",
    "generation": "2001  2005",
    "engine": "2.0  TS",
    "std_bhp": "150 hp",
    "tuned_bhp": "165 hp",
    "tuned_bhp_2": null,
    "std_torque": "172 Nm",
    "tuned_torque": "192 Nm",
    "tuned_torque_2": null,
    "title": "Alfa Romeo 147 2001  2005 2.0  TS"
}
</pre>
                            </div>
                        </div>

                   </div>
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
            Copyright © 2024 <a href="#">My Remaps</a>. All Rights Reserved
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
    </script>
    </body>
</html>
