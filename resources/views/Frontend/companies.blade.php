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
      
      <section id="intro" class="section intro">
        <div style="height: 72px"></div>
        <div class="container">
          <div class="col-md-10 col-md-offset-1 text-center">
            <h3>Compare Prices</h3>
            <p>Looking for a High Quality Remapping file supplier? Look no further. Whether you need a Stage 1, EGR Delete or even a DPF off, simply browse the selected companies below. The more info button also shows basic information about the capabilities of each company. Once you have chosen, click visit to work with your selected company.</p>
            <h3>Simple - Smart - Fast</h3>
          </div>
        </div>
      </section>

      <div class="client-table-outer" style="padding-top: 40px">
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
                      $logo = env('AZURE_STORAGE_URL').'uploads/'.$val['logo'];
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
        </div> <!-- End Container -->
      </div> <!-- End Client Table Outer -->

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
