@extends('Frontend.layouts.master')
@section('title')
  Welcome Remapdash
@endsection

@section('css')
<style>
  .section.api-intro{
    background-color: #18191c;
  }
        .api-carousel-wrapper {
            display: flex;
            align-items: center;
        }

        .img-block{
          max-width: 100%;
          max-height: 100%;
        }
        .img-block img{
            width: 100%;
            height: 100%;
        }
    </style>
@endsection

@section('content')

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
        <p style="margin-top: 20px;">Ready to buy? 
          <a class="btn btn-success view-btn" style="margin-left: 10px;" href="{{ route('frontend.api.reg') }}">Register Now</a>
        </p>
        <p>Already have an account? <a class="btn btn-success view-btn" style="margin-left: 10px;" href="{{ route('frontend.api.login') }}">Login</a></p>
        <p>If you need any help, please contact to <a class="custom-link" href="mailto:support@remapdash.com">support@remapdash.com</a></p>
      </div>
    </div>
  </section>
  <!-- End section API Intro -->
@endsection

@section('scripts')
<script src="{{ asset('customjs/front/main.js') }}"></script>
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
@endsection
