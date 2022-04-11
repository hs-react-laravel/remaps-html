
@extends('layouts/contentLayoutMaster')

@section('title', 'Dashboard')

@section('vendor-style')
  {{-- vendor css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection
@section('page-style')
  {{-- Page css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/dashboard-ecommerce.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/charts/chart-apex.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
@endsection

@section('content')
<!-- Dashboard Ecommerce Starts -->
<section id="dashboard-ecommerce">
  <div class="row match-height">
    <!-- Statistics Card -->
    <div class="col-12">
      @if($user->subscription_ended_string != NULL)
        @if(!$user->hasActiveSubscription())
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">{{ __('locale.dash_Subscription') }}</h4>
          </div>
          <div class="card-body">
            <p>{{ __('locale.dash_SubscriptionDesc') }}</p>
            <a class="btn btn-primary me-1" href="{{ route('packages.choose') }}">{{ __('locale.btn_ChoosePackages') }}</a>
          </div>
        </div>
        @else
        <div class="alert alert-warning">
          <p>
            {!! $user->subscription_ended_string !!}
          </p>
        </div>
        @endif
      @endif

      <div class="card card-statistics">
        <div class="card-header">
          <h4 class="card-title">{{ __('locale.menu_FileServices') }}</h4>
        </div>
        <div class="card-body statistics-body">
          <div class="row">
            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0" onclick="onFS('P')">
              <div class="d-flex flex-row">
                <div class="avatar bg-light-primary me-2">
                  <div class="avatar-content">
                    <i data-feather="trending-up" class="avatar-icon"></i>
                  </div>
                </div>
                <div class="my-auto">
                  <h4 class="fw-bolder mb-0" id="fs-pending"></h4>
                  <p class="card-text font-small-3 mb-0">{{ __('locale.dash_PendingFileService') }}</p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0" onclick="onFS('O')">
              <div class="d-flex flex-row">
                <div class="avatar bg-light-danger me-2">
                  <div class="avatar-content">
                    <i data-feather="book-open" class="avatar-icon"></i>
                  </div>
                </div>
                <div class="my-auto">
                  <h4 class="fw-bolder mb-0" id="fs-open"></h4>
                  <p class="card-text font-small-3 mb-0">{{ __('locale.dash_OpenFileService') }}</p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-sm-0" onclick="onFS('W')">
              <div class="d-flex flex-row">
                <div class="avatar bg-light-info me-2">
                  <div class="avatar-content">
                    <i data-feather="pause" class="avatar-icon"></i>
                  </div>
                </div>
                <div class="my-auto">
                  <h4 class="fw-bolder mb-0" id="fs-waiting"></h4>
                  <p class="card-text font-small-3 mb-0">{{ __('locale.dash_WaitingService') }}</p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12" onclick="onFS('C')">
              <div class="d-flex flex-row">
                <div class="avatar bg-light-success me-2">
                  <div class="avatar-content">
                    <i data-feather="check" class="avatar-icon"></i>
                  </div>
                </div>
                <div class="my-auto">
                  <h4 class="fw-bolder mb-0" id="fs-completed"></h4>
                  <p class="card-text font-small-3 mb-0">{{ __('locale.dash_CompletedService') }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/ Statistics Card -->
  </div>
  <div class="row match-height">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">{{ __('locale.dash_RecentOrders') }}</h4>
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th>{{ __('locale.title_OrderNo') }}</th>
                <th>{{ __('locale.tb_header_Date') }}</th>
                <th>{{ __('locale.tb_Customer') }}</th>
                <th>{{ __('locale.tb_header_Amount') }}</th>
                <th>{{ __('locale.tb_header_Status') }}</th>
                <th>{{ __('locale.tb_header_Options') }}</th>
              </tr>
            </thead>
            <tbody id="tbody"></tbody>
          </table>
          <a class="btn btn-primary me-1" href="{{ route('orders.index') }}">{{ __('locale.btn_ViewAllOrders') }}</a>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Dashboard Ecommerce ends -->
@endsection

@section('vendor-script')
  <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
@endsection
@section('page-script')
  <script>
    function onFS(status) {
      location.href = `/admin/fileservices?status=${status}`;
    }
    function fetchInfo() {
      $.ajax({
        type: 'GET',
        url: "{{ route('dashboard.admin.api') }}",
        success: function(result) {
          console.log(result);
          $('#fs-pending').html(result.fs_pending);
          $('#fs-open').html(result.fs_open);
          $('#fs-waiting').html(result.fs_waiting);
          $('#fs-completed').html(result.fs_completed);
          if (result.orders.length > 0) {
            var html = ''
            result.orders.forEach(o => {
              html += `
                <tr>
                  <td>${o.displayable_id}</td>
                  <td>${o.created_at}</td>
                  <td>${o.customer}</td>
                  <td>{{ config('constants.currency_signs')[$company->paypal_currency_code] }} ${o.amount_with_sign}</td>
                  <td>${o.status}</td>
                  <td>
                    <a class="btn btn-icon btn-success" href="/admin/orders/${o.id}/invoice" title="Download Invoice">
                      ${feather.icons['file'].toSvg()}
                    </a>
                  </td>
                </tr>
              `
            })
            $('#tbody').html(html)
          } else {
            $('#tbody').html('<tr><td colspan="6">No file services created by you yet!</td></tr>')
          }
        }
      })
    }
    fetchInfo()
    $(document).ready(function($) {
      setInterval(() => {
        fetchInfo()
      }, 5 * 1000);
    })
  </script>
@endsection
