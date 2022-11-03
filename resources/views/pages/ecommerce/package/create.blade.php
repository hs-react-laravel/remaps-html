
@extends('layouts/contentLayoutMaster')

@section('title', 'Create')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')

<section>
  <form action="{{ route('shoppackages.store') }}" method="post">
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
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="name">Amount</label>
                <input type="number" class="form-control" id="amount" name="amount" required />
              </div>
            </div>
            <div class="row mb-1">
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="name">Product Count</label>
                <input type="number" class="form-control" id="product_count" name="product_count" required />
              </div>
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="name">Digital Count</label>
                <input type="number" class="form-control" id="digital_count" name="digital_count" required />
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
            <div class="row mb-1">
              <div class="col-12">
                <label class="form-label" for="color">Card Color</label>
                <ul class="list-inline unstyled-list">
                  <li class="color-box bg-white border selected" data-color=""></li>
                  <li class="color-box bg-primary" data-color="primary"></li>
                  <li class="color-box bg-secondary" data-color="secondary"></li>
                  <li class="color-box bg-success" data-color="success"></li>
                  <li class="color-box bg-danger" data-color="danger"></li>
                  <li class="color-box bg-info" data-color="info"></li>
                  <li class="color-box bg-warning" data-color="warning"></li>
                  <li class="color-box bg-dark" data-color="dark"></li>
                  <li class="color-box bg-dblue" data-color="dblue"></li>
                  <li class="color-box bg-dgreen" data-color="dgreen"></li>
                  <li class="color-box bg-soil" data-color="soil"></li>
                  <li class="color-box bg-dred" data-color="dred"></li>
                  <li class="color-box bg-tred" data-color="tred"></li>
                </ul>
                <input type="hidden" name="color" id="color" value="">
              </div>
            </div>
            <button type="submit" class="btn btn-primary me-1">Submit</button>
            <button type="button" class="btn btn-flat-secondary me-1" onclick="history.back(-1)">Cancel</button>
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
    $('.color-box').click(function() {
      $('.color-box').removeClass('selected')
      $(this).addClass('selected')
      $('#color').val($(this).data('color'))
    })
  </script>
@endsection
