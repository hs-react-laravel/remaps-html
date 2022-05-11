@php
$configData = Helper::applClasses();
@endphp
<div class="main-menu menu-fixed {{
    (($configData['theme'] === 'dark') || ($configData['theme'] === 'semi-dark')) ? 'menu-dark' : 'menu-light'
  }} menu-accordion menu-shadow" data-scroll-to-active="true">
  <div class="navbar-header mt-1" style="height: 10rem; display: flex; align-items: center; justify-content:center;">
    <a href="{{ $user->is_admin ? route('dashboard.admin') : route('dashboard.customer') }}">
    <img src="{{ asset('storage/uploads/logo/'.$company->logo) }}" style="width: 100%; max-height: 140px; border-radius: 5px"></a>
  </div>
  <div class="shadow-bottom"></div>
  <div class="main-menu-content" style="height: calc(100% - 11rem) !important">
    @php
      $custom_classes = "";
      if(isset($menu->classlist)) {
        $custom_classes = $menu->classlist;
      }
    @endphp
    <ul class="navigation navigation-main {{ 'theme-'.substr($configData['navbarColor'], 3) }}" id="main-menu-navigation" data-menu="menu-navigation">
      {{-- Foreach menu item starts --}}
      @if(isset($menuData[0]))
      @foreach($menuData[0]->menu as $menu)
      @if(isset($menu->navheader))
      <li class="navigation-header">
        <span>{{ __('locale.'.$menu->navheader) }}</span>
        <i data-feather="more-horizontal"></i>
      </li>
      @else
      {{-- Add Custom Class with nav-item --}}
      @if($menu->name == 'external')
        @if($company->link_name && $company->link_value)
        <li class="nav-item {{ $custom_classes }}">
          <a href="{{$company->link_value}}" class="d-flex align-items-center" target="_blank">
            <i data-feather="{{ $menu->icon }}"></i>
            <span class="menu-title text-truncate">{{$company->link_name}}</span>
          </a>
        </li>
        @endif
      @else
        @php
          $badgeClasses = "badge-tickets badge rounded-pill badge-glow ".($configData['navbarColor'] != '' ? $configData['navbarColor'] : 'bg-primary')." ms-auto";
        @endphp
        @if (isset($menu->beta))
          @if ($company->id == 88)
          <li class="nav-item {{ $custom_classes }} {{Route::currentRouteName() === $menu->slug ? 'active' : ''}}">
            <a href="{{isset($menu->url)? url($menu->url):'javascript:void(0)'}}" class="d-flex align-items-center" target="{{isset($menu->newTab) ? '_blank':'_self'}}">
              <i data-feather="{{ $menu->icon }}"></i>
              <span class="menu-title text-truncate">{{ __('locale.'.$menu->name) }}</span>
              @if (($menu->url == 'admin/tickets' || $menu->url == 'customer/tk' || $menu->url == 'staff/stafftk') && $tickets_count)
              <span class="{{ isset($menu->badgeClass) ? $menu->badgeClass : $badgeClasses }}">{{$tickets_count}}</span>
              @endif
              @if (isset($menu->beta))
              <span class="{{ isset($menu->badgeClass) ? $menu->badgeClass : $badgeClasses }}">Beta</span>
              @endif
              @if ($menu->url == 'admin/shoporders' && $unchecked_orders > 0)
              <span class="{{ isset($menu->badgeClass) ? $menu->badgeClass : $badgeClasses }}">{{ $unchecked_orders }}</span>
              @endif
            </a>
            @if(isset($menu->submenu))
            @include('panels/submenu', ['menu' => $menu->submenu])
            @endif
          </li>
          @endif
        @else
          <li class="nav-item {{ $custom_classes }} {{Route::currentRouteName() === $menu->slug ? 'active' : ''}}">
            <a href="{{isset($menu->url)? url($menu->url):'javascript:void(0)'}}" class="d-flex align-items-center" target="{{isset($menu->newTab) ? '_blank':'_self'}}">
              <i data-feather="{{ $menu->icon }}"></i>
              <span class="menu-title text-truncate">{{ __('locale.'.$menu->name) }}</span>
              @if (($menu->url == 'admin/tickets' || $menu->url == 'customer/tk' || $menu->url == 'staff/stafftk') && $tickets_count)
              <span class="{{ isset($menu->badgeClass) ? $menu->badgeClass : $badgeClasses }}">{{$tickets_count}}</span>
              @endif
              @if ($menu->url == 'admin/shoporders' && $unchecked_orders > 0)
              <span class="{{ isset($menu->badgeClass) ? $menu->badgeClass : $badgeClasses }}">{{ $unchecked_orders }}</span>
              @endif
            </a>
            @if(isset($menu->submenu))
            @include('panels/submenu', ['menu' => $menu->submenu])
            @endif
          </li>
        @endif
      @endif
      @endif
      @endforeach
      @endif
      {{-- Foreach menu item ends --}}
      @if($role == 'customer' && $user->company->open_check)
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
                $timezone = Helper::companyTimeZone();
                $tz = \App\Models\Timezone::find($timezone ?? 1);
                $day_from = $company->$daymark_from;
                $day_to = $company->$daymark_to;
              @endphp
              <div class="openhours_sidebar_wrapper">
                <span class="bullet bullet-sm @if($company->$daymark_close) bullet-danger @else bullet-success @endif"></span>
                <span class="openhours_sidebar_day">{{ ucfirst($day) }}</span>
                <span class="openhours_sidebar_time">{{ !$company->$daymark_close ? $day_from.'-'.$day_to : 'Closed' }}</span>
              </div>
            @endforeach
          </div>
        </li>
      @endif
    </ul>
  </div>
</div>
<!-- END: Main Menu-->
