
@extends('layouts/contentLayoutMaster')

@section('title', 'Edit')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')

<section id="basic-input">
  {{ Form::model($entry, array('route' => array('shoppackages.update', $entry->id), 'method' => 'PUT')) }}
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Edit subscription package</h4>
          </div>
          <div class="card-body">
            <div class="row mb-1">
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $entry->name }}" />
              </div>
            </div>
            <div class="row mb-1">
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="billing_interval">Billing Type</label>
                <select class="form-select" id="billing_interval" name="billing_interval" disabled>
                  <option value="">-</option>
                  @foreach (config('constants.package_billing_interval') as $key => $interval)
                    <option value="{{ $key }}" @if($entry->billing_interval == $key) selected @endif>{{ $interval }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row mb-1">
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="name">Amount</label>
                <input type="number" class="form-control" id="amount" name="amount" disabled value="{{ $entry->amount }}" />
              </div>
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="name">Product Count</label>
                <input type="number" class="form-control" id="product_count" name="product_count" required value="{{ $entry->product_count }}" />
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
                >{{ $entry->description }}</textarea>
              </div>
            </div>
            <div class="row mb-1">
              <div class="col-12">
                <label class="form-label" for="color">Card Color</label>
                <ul class="list-inline unstyled-list">
                  <li class="color-box bg-white border @if(!$entry->color) selected @endif" data-color=""></li>
                  <li class="color-box bg-primary @if($entry->color == "primary") selected @endif" data-color="primary"></li>
                  <li class="color-box bg-secondary @if($entry->color == "secondary") selected @endif" data-color="secondary"></li>
                  <li class="color-box bg-success @if($entry->color == "success") selected @endif" data-color="success"></li>
                  <li class="color-box bg-danger @if($entry->color == "danger") selected @endif" data-color="danger"></li>
                  <li class="color-box bg-info @if($entry->color == "info") selected @endif" data-color="info"></li>
                  <li class="color-box bg-warning @if($entry->color == "warning") selected @endif" data-color="warning"></li>
                  <li class="color-box bg-dark @if($entry->color == "dark") selected @endif" data-color="dark"></li>
                  <li class="color-box bg-dblue @if($entry->color == "dblue") selected @endif" data-color="dblue"></li>
                  <li class="color-box bg-dgreen @if($entry->color == "dgreen") selected @endif" data-color="dgreen"></li>
                  <li class="color-box bg-soil @if($entry->color == "soil") selected @endif" data-color="soil"></li>
                  <li class="color-box bg-dred @if($entry->color == "dred") selected @endif" data-color="dred"></li>
                  <li class="color-box bg-tred @if($entry->color == "tred") selected @endif" data-color="tred"></li>
                </ul>
                <input type="hidden" name="color" id="color" value="{{ $entry->color }}">
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
