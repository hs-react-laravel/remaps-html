@php
$configData = Helper::applClasses();
@endphp
<div class="main-menu menu-fixed {{(($configData['theme'] === 'dark') || ($configData['theme'] === 'semi-dark')) ? 'menu-dark' : 'menu-light'}} menu-accordion menu-shadow" data-scroll-to-active="true">
  <div class="navbar-header mt-1" style="height: 10rem">
    <a href="{{ $user->is_admin ? route('dashboard.admin') : route('dashboard.customer') }}">
    <img src="{{ asset('storage/uploads/logo/'.$company->logo) }}" style="width: 100%; height: 100%; border-radius: 5px"></a>
  </div>
  <div class="shadow-bottom"></div>
  <div class="main-menu-content" style="height: calc(100% - 11rem) !important">
    @php
      $custom_classes = "";
      if(isset($menu->classlist)) {
        $custom_classes = $menu->classlist;
      }
    @endphp
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
      {{-- Foreach menu item starts --}}
      @if(isset($menuData[0]))
      @foreach($menuData[0]->menu as $menu)
      @if(isset($menu->navheader))
      <li class="navigation-header">
        <span>{{ __('locale.menu.'.$menu->navheader) }}</span>
        <i data-feather="more-horizontal"></i>
      </li>
      @else
      {{-- Add Custom Class with nav-item --}}
      @if($menu->name != 'external')
        <li class="nav-item {{ $custom_classes }} {{Route::currentRouteName() === $menu->slug ? 'active' : ''}}">
          <a href="{{isset($menu->url)? url($menu->url):'javascript:void(0)'}}" class="d-flex align-items-center" target="{{isset($menu->newTab) ? '_blank':'_self'}}">
            <i data-feather="{{ $menu->icon }}"></i>
            <span class="menu-title text-truncate">{{ __('locale.menu.'.$menu->name) }}</span>
            @if (isset($menu->badge))
            <?php $badgeClasses = "badge rounded-pill badge-light-primary ms-auto me-1" ?>
            <span class="{{ isset($menu->badgeClass) ? $menu->badgeClass : $badgeClasses }}">{{$menu->badge}}</span>
            @endif
          </a>
          @if(isset($menu->submenu))
          @include('panels/submenu', ['menu' => $menu->submenu])
          @endif
        </li>
      @else
        @if($company->link_name && $company->link_value)
        <li class="nav-item {{ $custom_classes }}">
          <a href="{{$company->link_value}}" class="d-flex align-items-center" target="_blank">
            <i data-feather="{{ $menu->icon }}"></i>
            <span class="menu-title text-truncate">{{$company->link_name}}</span>
          </a>
        </li>
        @endif
      @endif
      @endif
      @endforeach
      @endif
      {{-- Foreach menu item ends --}}
      @if($role == 'customer')
        @php
          $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']
        @endphp
        <li class="nav-item {{ $custom_classes }}">
          <div style="margin-top: 15px">
            <div class="openhours_sidebar_wrapper">Opening Hours</div>
            @foreach ($days as $day)
              @php
                $daymark_close = substr($day, 0, 3).'_close';
                $daymark_from = substr($day, 0, 3).'_from';
                $daymark_to = substr($day, 0, 3).'_to';
              @endphp
              <div class="openhours_sidebar_wrapper">
                <span class="bullet bullet-sm @if($company->$daymark_close) bullet-danger @else bullet-success @endif"></span>
                <span class="openhours_sidebar_day">{{ ucfirst($day) }}</span>
                <span class="openhours_sidebar_time">{{ !$company->$daymark_close ? $company->$daymark_from.'-'.$company->$daymark_to : 'Closed' }}</span>
              </div>
            @endforeach
          </div>
        </li>
      @endif
    </ul>
  </div>
</div>
<!-- END: Main Menu-->
