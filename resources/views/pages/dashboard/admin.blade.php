
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

      @foreach ($updateTickets as $ut)
        <div class="alert alert-{{ $ut->theme }}" role="alert">
            <div class="alert-body"><strong>{{ date_format($ut->updated_at, 'd/m/Y') }}</strong> {{ $ut->message }}</div>
        </div>
      @endforeach

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
  <div class="col-12">
      <div class="card">
          <div class="card-header">
              <h4 class="card-title">History of Changes</h4>
          </div>
          <div class="card-body">
              <p>{!! $bottomUpdate->body !!}</p>
          </div>
      </div>
  </div>
</section>
{{ Form::open(array('id' => 'uploadForm', 'route' => 'api.order.upload', 'method' => 'POST', 'enctype' => 'multipart/form-data')) }}
  <input type="file" name="file" id="hidden_upload" style="display: none" />
  <input type="hidden" name="order" id="order_id" />
{{ Form::close() }}
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
                  @if (!$company->is_invoice_pdf)
                    <a class="btn btn-icon btn-success" href="/admin/orders/${o.id}/invoice" title="Download Invoice">
                      ${feather.icons['file'].toSvg()}
                    </a>
                  @endif
                  @if ($company->is_invoice_pdf)
                    <a class="btn btn-icon btn-success" id="download-link-${o.id}" href="/admin/orders/${o.id}/download" title="Download Invoice" style="${o.document ? '' : 'display: none'}">
                      ${feather.icons['file'].toSvg()}
                    </a>
                  @endif
                  @if ($company->is_invoice_pdf)
                    <button class="btn btn-icon btn-success" title="Upload Invoice PDF" onclick="onUpload(${o.id})">
                      ${feather.icons['upload'].toSvg()}
                    </button>
                  @endif
                  <div class="progress progress-bar-{{ substr($styling['navbarColor'], 3) }}" style="margin-top: 3px; display:none" id="progress-${o.id}">
                    <div
                      class="progress-bar progress-bar-striped progress-bar-animated"
                      id="progress-bar-${o.id}"
                      role="progressbar"
                      aria-valuenow="0"
                      aria-valuemin="0"
                      aria-valuemax="100"
                    ></div>
                  </div>
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

    function onUpload(id) {
      $('#hidden_upload').trigger('click');
      $('#order_id').val(id);
      $('#hidden_upload').change(function (e) {
        $('#uploadForm').submit();
      })
    }
    $("#uploadForm").on('submit', function(e){
      var id = $('#order_id').val();
      e.preventDefault();
      $.ajax({
        xhr: function() {
          var xhr = new window.XMLHttpRequest();
          xhr.upload.addEventListener("progress", function(evt) {
            if (evt.lengthComputable) {
              var percentComplete = Math.round((evt.loaded / evt.total) * 100);
              $("#progress-bar-" + id).width(percentComplete + '%');
              $("#progress-bar-" + id).html(percentComplete+'%');
            }
          }, false);
          return xhr;
        },
        type: 'POST',
        url: "{{ route('api.order.upload') }}",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function(){
          $("#progress-bar-" + id).width('0%');
          $("#progress-" + id).show();
        },
        error:function(){

        },
        success: function(resp){
          if(resp.status){
            $('#uploadForm')[0].reset();
            setTimeout(() => {
              $("#progress-" + id).hide();
              $("#download-link-" + id).show();
            }, 2000);
          }else{
          }
        }
      });
    })
  </script>
@endsection
