<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico')}}">
    @include('Frontend.layouts.head')
  </head>

  <body>
    <div class="page-wrapper">
      <!-- Preloader -->
      <!-- <div class="preloader"></div> -->

      @include('Frontend.layouts.topbar')

      @yield('content')

      @include('Frontend.layouts.footer')
    </div><!-- End Page Wrapper -->

    <!-- Scroll To Top -->
    <div class="scroll-to-top scroll-to-target" data-target="html"><span class="fa fa-angle-up"></span></div>


    @include('Frontend.layouts.scripts')
  </body>
</html>