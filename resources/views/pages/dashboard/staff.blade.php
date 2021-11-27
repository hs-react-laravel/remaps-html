
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
      <div class="card card-statistics">
        <div class="card-header">
          <h4 class="card-title">File Services</h4>
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
                  <h4 class="fw-bolder mb-0">{{ $data['fs_pending'] }}</h4>
                  <p class="card-text font-small-3 mb-0">Upload Pending</p>
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
                  <h4 class="fw-bolder mb-0">{{ $data['fs_open'] }}</h4>
                  <p class="card-text font-small-3 mb-0">Open</p>
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
                  <h4 class="fw-bolder mb-0">{{ $data['fs_waiting'] }}</h4>
                  <p class="card-text font-small-3 mb-0">Waiting</p>
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
                  <h4 class="fw-bolder mb-0">{{ $data['fs_completed'] }}</h4>
                  <p class="card-text font-small-3 mb-0">Completed</p>
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
          <h4 class="card-title">Recent file service</h4>
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th>No.</th>
                <th>Car</th>
                <th>Created</th>
                <th>Status</th>
                <th>Options</th>
              </tr>
            </thead>
              <tbody>
                @if($data['fileServices']->count() > 0)
                  @foreach($data['fileServices'] as $fileService)
                    <tr>
                      <td>{{ $fileService->displayable_id }}</td>
                      <td>{{ $fileService->car }}</td>
                      <td>{{ $fileService->created_at }}</td>
                      <td>{{ $fileService->status }}</td>
                      <td>
                        <a class="btn btn-icon btn-primary" href="{{ route('fileservices.edit', ['fileservice' => $fileService->id]) }}">
                          <i data-feather="edit"></i>
                        </a>
                        <a
                          class="btn btn-icon btn-success"
                          href="{{ $fileService->tickets
                            ? route('tickets.edit', ['ticket' => $fileService->tickets->id])
                            : route('fileservice.tickets.create', ['id' => $fileService->id]) }}">
                          <i data-feather="message-circle"></i>
                        </a>
                      </td>
                    </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="5">No file services created by you yet!</td>
                  </tr>
                @endif
            </tbody>
          </table>
          <a class="btn btn-primary me-1 mt-2" href="{{ route('stafffs.index') }}">View All File Services</a>
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
      location.href = `/staff/stafffs?status=${status}`;
    }
  </script>
@endsection
