@isset($pageConfigs)
{!! Helper::updatePageConfig($pageConfigs) !!}
@endisset

<!DOCTYPE html>
@php $configData = Helper::applClasses(); @endphp

<html class="loading {{($configData['theme'] === 'light') ? '' : $configData['layoutTheme'] }}"
lang="@if(session()->has('locale')){{session()->get('locale')}}@else{{$configData['defaultLanguage']}}@endif"
data-textdirection="{{ env('MIX_CONTENT_DIRECTION') === 'rtl' ? 'rtl' : 'ltr' }}"
@if($configData['theme'] === 'dark') data-layout="dark-layout"@endif>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="Welcome to the {{ $company->name }} tuning file service. {{ $company->name }} provide high quality dyno tested tuning files for most makes and models.">
  <meta name="keywords" content="remap, dashboard, car, tuning, advanced, service">
  <meta name="author" content="PIXINVENT">
  <title>@yield('title')</title>
  {{-- <link rel="apple-touch-icon" href="{{asset('images/ico/apple-icon-120.png')}}">
  <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/logo/favicon.ico')}}"> --}}
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

  {{-- Include core + vendor Styles --}}
  @include('panels/styles')

  {{-- Include core + vendor Styles --}}
  @include('panels/styles')
</head>



<body class="vertical-layout vertical-menu-modern {{ $configData['bodyClass'] }} {{($configData['theme'] === 'dark') ? 'dark-layout' : ''}} {{ $configData['blankPageClass'] }} blank-page"
data-menu="vertical-menu-modern"
data-col="blank-page"
data-framework="laravel"
data-asset-path="{{ asset('/')}}">

  <!-- BEGIN: Content-->
  <div class="app-content content {{ $configData['pageClass'] }} {{ 'theme-'.substr($configData['navbarColor'], 3) }}">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>

    <div class="content-wrapper">
      <div class="content-body">

        {{-- Include Startkit Content --}}
        @yield('content')

      </div>
    </div>
  </div>
  <!-- End: Content-->

  {{-- include default scripts --}}
  @include('panels/scripts')

  <script type="text/javascript">
    $(window).on('load', function() {
      if (feather) {
        feather.replace({
          width: 14,
          height: 14
        });
      }
    })
  </script>
  <script>
    var textColor = "#7367f0";
    var navbarStyle = "{{ $configData['navbarColor'] }}";
    switch(navbarStyle) {
        case 'bg-secondary':
            textColor = '#82868b'
            break;
        case 'bg-success':
            textColor = '#28c76f'
            break;
        case 'bg-danger':
            textColor = '#ea5455'
            break;
        case 'bg-info':
            textColor = '#00cfe8'
            break;
        case 'bg-warning':
            textColor = '#ff9f43'
            break;
        case 'bg-dark':
            textColor = '#4b4b4b'
            break;
        case 'bg-primary':
        default:
            textColor = '#7367f0'
            break;
    }
    var canvas = document.createElement('canvas');
    canvas.width = 32;canvas.height = 32;
    var ctx = canvas.getContext('2d');
    var img = new Image();
    ctx.fillStyle = "#FFF";
    ctx.fillRect(0, 0, 32, 32);
    ctx.fillStyle = textColor;
    ctx.font = 'bold 20px sans-serif';
    ctx.fillText(getInitials('{{ $company->name }}'), 0, 24);

    var link = document.createElement('link');
    link.type = 'image/x-icon';
    link.rel = 'shortcut icon';
    link.href = canvas.toDataURL("image/x-icon");
    document.getElementsByTagName('head')[0].appendChild(link);

    function getInitials(name) {
        let initials = name.split(' ');

        if(initials.length > 1) {
            initials = initials.shift().charAt(0) + initials.shift().charAt(0);
        } else {
            initials = name.substring(0, 2);
        }

        return initials.toUpperCase();
    }
</script>

</body>

</html>
