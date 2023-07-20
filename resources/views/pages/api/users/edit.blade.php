
@extends('layouts/contentLayoutMaster')

@section('title', 'Create a Customer')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')

<section id="basic-input">
    {{ Form::model($entry, array('route' => array('apiusers.update', $entry->id), 'method' => 'PUT')) }}
    @csrf
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Edit Api User</h4>
          </div>
          <div class="card-body">
            <div class="row mb-1">
              <div class="col-xl-3 col-md-6 col-12">
                <label class="form-label" for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $entry->first_name }}" />
              </div>
              <div class="col-xl-3 col-md-6 col-12">
                <label class="form-label" for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $entry->last_name }}" />
              </div>
            </div>
            <div class="row mb-1">
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="{{ $entry->email }}" />
              </div>
            </div>
            <div class="row mb-1">
                <div class="col-xl-4 col-md-6 col-12">
                  <label class="form-label" for="new_password">Password</label>
                  <input type="text" class="form-control" id="new_password" name="new_password" />
                </div>
            </div>
            <div class="row mb-1">
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ $entry->phone }}" />
              </div>
            </div>
            <div class="row mb-1">
              <div class="col-xl-8 col-md-8 col-12">
                <label class="form-label" for="api_token">Token</label>
                <div class="input-group">
                  <input type="text" class="form-control" id="api_token" name="api_token" value="{{ $entry->api_token }}" readonly />
                  <span class="input-group-text cursor-pointer" onclick="onGenerateToken()"><i data-feather="edit"></i></span>
                  <span class="input-group-text cursor-pointer" onclick="onCopy()"><i data-feather="copy"></i></span>
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary me-1">Submit</button>
            <button type="button" class="btn btn-flat-secondary me-1" onclick="history.back(-1)">Cancel</button>
          </div>
        </div>
      </div>
    </div>

    {{ Form::close() }}
</section>

@endsection

@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection
@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/forms/form-tooltip-valid.js'))}}"></script>
  <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
  <script>
      function onGenerateToken() {
        $.ajax({
            type: 'GET',
            url: "{{ route('apiuser.api.generate') }}",
            success: function(result) {
                $('#api_token').val(result);
            }
        })
      }
      function onCopy() {
          $('#api_token').select();
          document.execCommand('copy');
      }
  </script>
@endsection
