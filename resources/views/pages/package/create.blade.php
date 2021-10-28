
@extends('layouts/contentLayoutMaster')

@section('title', 'Input')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')

<section id="basic-input">
  <form action="{{ route('packages.store') }}" method="post">
    @csrf
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Add a subscription package</h4>
          </div>
          <div class="card-body">
            <div class="row mb-1">
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required />
              </div>
            </div>
            <div class="row mb-1">
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="billing_interval">Billing Type</label>
                <select class="form-select" id="billing_interval" name="billing_interval" required>
                  <option value="">-</option>
                  @foreach (config('constants.package_billing_interval') as $key => $interval)
                    <option value="{{ $key }}">{{ $interval }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row mb-1">
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="name">Amount</label>
                <input type="number" class="form-control" id="amount" name="amount" required />
              </div>
            </div>
            <div class="row mb-1">
              <div class="col-12">
                <label class="form-label" for="body">Description</label>
                <textarea
                  class="form-control ckeditor"
                  id="body"
                  rows="20"
                  name="description"
                ></textarea>
              </div>
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-primary me-1">Submit</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
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
  <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
  <script type="text/javascript">
    $(document).ready(function () {
        CKEDITOR.replace('body');
    });
  </script>
@endsection
