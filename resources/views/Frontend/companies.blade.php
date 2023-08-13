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

    <style>

        .ratings {
          position: relative;
          vertical-align: middle;
          display: inline-block;
          color: #b1b1b1;
          overflow: hidden;
        }

        .full-stars{
          position: absolute;
          left: 0;
          top: 0;
          white-space: nowrap;
          overflow: hidden;
          color: #fde16d;
        }

        .empty-stars:before,
        .full-stars:before {
          content: "\2605\2605\2605\2605\2605";
          font-size: 14pt;
        }

        .empty-stars:before {
          -webkit-text-stroke: 1px #848484;
        }

        .full-stars:before {
          -webkit-text-stroke: 1px orange;
        }

        /* Webkit-text-stroke is not supported on firefox or IE */
        /* Firefox */
        @-moz-document url-prefix() {
          .full-stars{
            color: #ECBE24;
          }
        }
        /* IE */
        </style>

    <body>
    <!-- header section -->
    <section class="banner" role="banner" id="home">
        <header id="header" class="fixed">
            <div class="header-content clearfix"> <a class="logo" href="/"><img src="customcss/front/images/logo.png" alt="logo"></a>
              <nav class="navigation" role="navigation">
                <ul class="primary-nav">
                 <li><a href="/#home" class="">Home</a></li>
                  <li><a href="/#howitworks" class="">How it works</a></li>
                  <li><a href="/#features" class="">Features</a></li>
                  <li><a href="/#price">Price</a></li>
                  <li><a href="/#about" class="">About</a></li>
                  <li><a href="#" class="active">Companies</a></li>
                  <li><a href="/api-intro">API</a></li>
                </ul>
              </nav>
              <a href="#" class="nav-toggle">Menu<span></span></a>
            </div>
        </header>
      <!-- banner text -->
        <div style="height: 72px">

        </div>
    </section>

    <section id="intro" class="section intro">
        <div class="container">
          <div class="col-md-10 col-md-offset-1 text-center">
            <h3>Compare Prices</h3>
            <p>Looking for a High Quality Remapping file supplier? Look no further. Whether you need a Stage 1, EGR Delete or even a DPF off, simply browse the selected companies below. The more info button also shows basic information about the capabilities of each company. Once you have chosen, click visit to work with your selected company.</p>
            <h3>Simple - Smart - Fast</h3>
          </div>
        </div>
    </section>

    <div class="client-table-outer" style="margin-top: 40px">
		<div class="container">
			<div class="client-table">
				<div class="table-responsive">
					<table class="table table-bordered text-center" style="color:white;">
						<tr>
							<th class="text-center">Name</th>
							<th class="text-center">Logo</th>
							<th class="text-center">Tuning Credits</th>
							<th class="text-center">
								Rating
								@php
									$url = "compare-prices?keyword=rating&sort=ASC" ;
								@endphp
							</th>
							<th class="text-center">Visit</th>
						</tr>

						@php
								$i=1;

						@endphp
						@foreach($companies as $val)
							@php
								$childTable = $val['tuning_credit_groups'];
								$j =0;
								$datas =[];
								foreach($childTable as $childs):
									foreach($childs['tuning_credit_tires'] as $pivot){
										if($childs['set_default_tier'] ==1){

											$datas[$j] = array(
												'from_credit'=>$pivot['pivot']['from_credit'],
												'for_credit'=>$pivot['pivot']['for_credit'],
												'amount'=>$pivot['amount']
											);

											$j++;
										}
									}
								endforeach;
						$from = $for ='';
						if(!empty($datas)){
								$maxAmount = max(array_column($datas, 'amount'));
								$minAmount = min(array_column($datas, 'amount'));

								foreach($datas as $vals){
									if($vals['amount'] == $minAmount){
										$from =  min($vals['from_credit'],$vals['for_credit']);
										$from = $minAmount == 0 ? 0 : $from/$minAmount;
									}
									if($vals['amount'] == $maxAmount){
										$for =  min($vals['from_credit'],$vals['for_credit']);
										$for = $maxAmount == 0 ? 0 :$for/$maxAmount;
									}
								}
						}
								/*
									$max1 = max(array_column($datas, 'from_credit'));
									$max = $max2 = max(array_column($datas, 'for_credit'));
									if($max1 >$max2){
										$max = $max1;
									}

									$min1 = min(array_column($datas, 'from_credit'));
									$min = $min2 = min(array_column($datas, 'for_credit'));
								*/
						@endphp
								<?php
									/*if($min1 <= $min2):
										$min = $min1;
									endif;*/
								?>
								@php
									$logo = 'storage/uploads/logo/'.$val['logo'];
									$link =$val['v2_domain_link'];
								@endphp
								<tr>
									<td class="">
											@php echo $val['name'] @endphp
									</td>
									<td>

										<div class="clt-lg">
											<a href="@php echo $link @endphp" target="_blank">
												<img src="{{ URL::asset("$logo") }}" alt="logo" class="tbl-logo" style="width: 128px">
											</a>
										</div>

									</td>
									<td>
										@php
											if(!empty($from)){
												$max = round(max($from,$for));
												$min = round(min($from,$for));
												echo 'from  £'.$min.' to  £'.$max;
											}else{
												echo '-';
											}
										@endphp
									</td>
									<!------<td>2019 - 2020</td>------->
                                    @php
                                        $id = $val['id'];
                                        $name = $val['name'];
                                        $addressLine1 = $val['address_line_1'];
                                        $country = $val['country'];
                                        $state = $val['state'];
                                        $town = $val['town'];

                                        $rating = $val['rating'];
                                        $ratings = $val['rating']*20;
                                        $email = $val['support_email_address'];
                                        $moreinfo = $val['more_info'];
                                    @endphp
									<td>
										<div class="rating-box">
											<div class="ratings">
												  <div class="empty-stars"></div>
												  <div class="full-stars" style="width:@php echo $ratings.'%'; @endphp"></div>
											</div>
											<!----
											@for($i=1;$i<=5;$i++)

												@php
													if($i <= $rating){
												@endphp
														<span class="fa fa-star checked"></span>
												@php
													}else{
												@endphp
														<span class="fa fa-star"></span>
												@php
													}
												@endphp
											@endfor
											----->
										</div>
									</td>

									<td>
										<div class="clt-lg client-table">
										  	<center>
												  <a class="more-btn" href="@php echo $link @endphp" target="_blank">
													Visit
													</a>
										  	</center>
									 	 </div>
									</td>
								</tr>
						@php $i++; @endphp
						@endforeach
					</table>
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
    </script>
    </body>
</html>
