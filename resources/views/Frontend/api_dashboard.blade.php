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
        <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
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
                   <div class="footer_about">
                        <p>Name: <span style="color: #fec400">{{ $apiUser->fullName }}</span></p>
                        <p>API Token:<br/>
                            <span style="color: #fec400">{{ $apiUser->api_token }}</span></p>
                        </p>
                        @if (!$apiUser->hasActiveSubscription())
                            You haven't subscribed yet. <a class="custome-link" href="{{route('frontend.api.sub', ['token' => $apiUser->api_token])}}">Click here</a>
                        @else
                            <p>You have active subscription payment. <br/>
                                For details of api usage, <a href="/api-doc">click here</a>
                            </p>
                        @endif

                        <p>
                            <a href="{{ route('frontend.api.logout') }}" style="color: #D85E00">Log out</a>
                        </p>

                        <h5 style="color:white" class="mt-md-5 mb-4"><i class="fa-solid fa-code"></i>  Embed code</h5>
                        <div class="card mb-2 p-3">
                            <div class="card-body">
                                <pre class="mb-0 text-danger-emphasis">&lt;script src="{{ route('api.snippet.js', ['id' => $apiUser->id]) }}"&gt;&lt;/script&gt;</pre>
                            </div>
                        </div>
                        <h5 style="color:white" class="mt-md-5 mb-4"><i class="fa-solid fa-palette"></i>  Color Customization</h5>
                        <div class="card mb-4">
                            <div class="card-header"><h5 class="mb-0">Theme</h5></div>
                            <div class="card-body">
                                <p>The theme of the widget, dark or light. Defaults to <span class="badge text-bg-dark border">light</span></p>
                                <hr>
                                <strong>URL variable:</strong> <span class="badge text-info bg-info-subtle border border-info">theme</span><br>
                                <strong>Accepted parameters:</strong> <span class="badge bg-light-subtle text-body border">light</span> or <span class="badge bg-light-subtle text-body border">dark</span>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header"><h5 class="mb-0">Highlight colour</h5></div>
                            <div class="card-body">
                                <p>The accent colour defaults to <span class="badge text-white" style="background: #ffffff; color: black;">white</span></p>
                                <hr>
                                <strong>URL variable:</strong> <span class="badge text-info bg-info-subtle border border-info">color</span><br>
                                <strong>Accepted parameters:</strong> 6 character colour hex code without preceding hash. EG: <span class="badge bg-light-subtle text-body border">ff0000</span>.
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header"><h5 class="mb-0">Button text colour</h5></div>
                            <div class="card-body">
                                <p>This specifies the colour of the text within the buttons.</p>
                                <hr>
                                <strong>URL variable:</strong> <span class="badge text-info bg-info-subtle border border-info">buttontext</span><br>
                                <strong>Accepted parameters:</strong> 6 character colour hex code without preceding hash. EG: <span class="badge bg-light-subtle text-body border">ffffff</span>.
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header"><h5 class="mb-0">Background colour</h5></div>
                            <div class="card-body">
                                <p>The background colour defaults to <span class="badge text-info bg-info-subtle border border-info">transparent</span> when not specified.</p>
                                <hr>
                                <strong>URL variable:</strong> <span class="badge text-info bg-info-subtle border border-info">bgcolor</span><br>
                                <strong>Accepted parameters:</strong> 6 character colour hex code without preceding hash. EG: <span class="badge bg-light-subtle text-body border">ffffff</span>.
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header"><h5 class="mb-0">Padding</h5></div>
                            <div class="card-body">
                                <p>Padding pixels inside frame. Defaults to <span class="badge">10</span></p>
                                <hr>
                                <strong>URL variable:</strong> <span class="badge text-info bg-info-subtle border border-info">px</span><br>
                                <strong>Accepted parameters:</strong> Number EG: <span class="badge bg-light-subtle text-body border">10</span>.
                                <br/>
                                <br/>
                                <strong>URL variable:</strong> <span class="badge text-info bg-info-subtle border border-info">py</span><br>
                                <strong>Accepted parameters:</strong> Number EG: <span class="badge bg-light-subtle text-body border">10</span>.
                            </div>
                        </div>
                        <h5 style="color:white" class="mt-md-5 mb-4"><i class="fa-solid fa-code"></i>  Here's an example of your embed code with customised colours:</h5>
                        <div class="card mb-2 p-3">
                            <div class="card-body">
                                <pre class="mb-0 text-danger-emphasis">&lt;script src="{{ route('api.snippet.js', ['id' => $apiUser->id, 'theme' => 'light', 'color' => 'CB5252']) }}"&gt;&lt;/script&gt;</pre>
                            </div>
                        </div>
                        <h5 style="color:white" class="mt-md-5 mb-4"><i class="fa-regular fa-file-lines"></i>  Text Customization</h5>
                        <div class="card mb-4">
                            <div class="card-header"><h5 class="mb-0">Information Text</h5></div>
                            <div class="card-body">
                                {!! Form::open(array('route' => ('frontend.api.template.save'), 'method' => 'POST')) !!}
                                <div>
                                    <input type="hidden" name="id" value="{{ $apiUser->id }}">
                                    <input type="hidden" name="body_default" value="0" />
                                    <input type="checkbox" id="chktc" name="body_default" value="1" @if($apiUser->body_default) checked @endif>
                                    <label for="vehicle1">Use Vendor's default text</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;<a style="cursor: pointer" onclick="onPasteTemplate()">Paste default template</a>
                                </div>
                                <textarea
                                    class="form-control"
                                    id="cked"
                                    rows="20"
                                    name="body"
                                >{{ $apiUser->body }}</textarea>
                                <button id="btnSubmit" class="btn btn-success view-btn" style="margin-top: 20px;" type="submit">Save</button>
                                {!! Form::close() !!}
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
        $(window).on('load', function (){
            $('body').scrollTop(1);
        });
    </script>

    <script type="text/javascript">
        $(window).on('load', function (){
            CKEDITOR.replace('cked');
            @if($apiUser->body_default)
                CKEDITOR.config.readOnly = true;
            @endif
        });
        function onPasteTemplate() {
            if ($('#chktc').is(':checked')) {
                return
            }
            $.ajax({
                url: `/api/car-text-template`,
                type: 'GET',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function (data) {
                    CKEDITOR.instances.cked.setData(data);
                }
            });
        }
        $('#chktc').change(function(){
            if ($(this).is(':checked')) {
                CKEDITOR.instances.cked.setReadOnly(true);
            } else {
                CKEDITOR.instances.cked.setReadOnly(false);
            }
        })
    </script>
    </body>
</html>
