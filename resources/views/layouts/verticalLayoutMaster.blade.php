<body class="vertical-layout vertical-menu-modern {{ $configData['verticalMenuNavbarType'] }} {{ $configData['blankPageClass'] }} {{ $configData['bodyClass'] }} {{ $configData['sidebarClass']}} {{ $configData['footerType'] }} {{$configData['contentLayout']}}"
data-open="click"
data-menu="vertical-menu-modern"
data-col="{{$configData['showMenu'] ? $configData['contentLayout'] : '1-column' }}"
data-framework="laravel"
data-asset-path="{{ asset('/')}}">
  <!-- BEGIN: Header-->
  @include('panels.navbar')
  <!-- END: Header-->

  <!-- BEGIN: Main Menu-->
  @if((isset($configData['showMenu']) && $configData['showMenu'] === true))
  @include('panels.sidebar')
  @endif
  <!-- END: Main Menu-->

  <!-- BEGIN: Content-->
  <div class="app-content content {{ $configData['pageClass'] }} {{ 'theme-'.substr($configData['navbarColor'], 3) }}">
    <!-- BEGIN: Header-->
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>

    @if(($configData['contentLayout']!=='default') && isset($configData['contentLayout']))
    <div class="content-area-wrapper {{ $configData['layoutWidth'] === 'boxed' ? 'container-xxl p-0' : '' }}">
      <div class="{{ $configData['sidebarPositionClass'] }}">
        <div class="sidebar">
          {{-- Include Sidebar Content --}}
          @yield('content-sidebar')
        </div>
      </div>
      <div class="{{ $configData['contentsidebarClass'] }}">
        <div class="content-wrapper">
          <div class="content-body">
            {{-- Include Page Content --}}
            @yield('content')
          </div>
        </div>
      </div>
    </div>
    @else
    <div class="content-wrapper {{ $configData['layoutWidth'] === 'boxed' ? 'container-xxl p-0' : '' }}">
      {{-- Include Breadcrumb --}}
      @if($configData['pageHeader'] === true && isset($configData['pageHeader']))
      {{-- @include('panels.breadcrumb') --}}
      @endif

      <div class="content-body">
        {{-- Include Page Content --}}
        @yield('content')
      </div>
    </div>
    @endif

  </div>
  <!-- End: Content-->

  @if($configData['blankPage'] == false && isset($configData['blankPage']))
  <!-- BEGIN: Customizer-->
  @if($user->is_admin || $user->is_staff)
  @include('content/pages/customizer')
  @endif
  <!-- End: Customizer-->
  <!-- Buynow Button-->
  {{-- @include('content/pages/buy-now') --}}
  @endif

  <div class="sidenav-overlay"></div>
  <div class="drag-target"></div>

  {{-- include footer --}}
  @include('panels/footer')

  {{-- include default scripts --}}
  @include('panels/scripts')

  <script type="text/javascript">
    $(window).on('load', function() {
      if (feather) {
        feather.replace({
          width: 14, height: 14
        });
      }
    })
    function onChangeCart(obj) {
      $.ajax({
        url: '{{ route("customer.shop.cart.update") }}',
        type: 'POST',
        data: {
          _token: '{{ csrf_token() }}',
          id: $(obj).data('cartid'),
          amount: $(obj).val()
        },
        dataType: 'JSON',
        success: function (data) {
          let amountLabel = $(obj).closest('.list-item').find('.cart-item-price')
          $(amountLabel).html(data.newAmount)
          let totalLabel = $(obj).closest('.dropdown-menu-media').find('.cart-total-price')
          $(totalLabel).html(data.totalAmount)
          let countLabel = $('.cart-item-count')
          $(countLabel).html(data.itemCount)
        }
      });
    }
    function onRemoveCart(obj) {
      $.ajax({
        url: '{{ route("customer.shop.cart.delete") }}',
        type: 'POST',
        data: {
          _token: '{{ csrf_token() }}',
          id: $(obj).data('cartid')
        },
        dataType: 'JSON',
        success: function (data) {
          let totalLabel = $(obj).closest('.dropdown-menu-media').find('.cart-total-price')
          $(totalLabel).html(data.totalAmount)
          let countLabel = $('.cart-item-count')
          $(countLabel).html(data.itemCount)
          if (data.itemCount == 0) {
            $(countLabel).hide()
          }
          let cartItem = $(obj).closest('.list-item')
          $(cartItem).remove()
        }
      });
    }
    function onAddCartInline(obj) {
        console.log('add cart')
      let form = $(obj).parent().find('.add-cart-inline-form')
      $(form).submit()
    }
  </script>
</body>
</html>
