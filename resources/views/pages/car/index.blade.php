
@extends('layouts/contentLayoutMaster')

@section('title', 'Browse Specs')

@section('vendor-style')
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('page-style')
  <link rel="stylesheet" href="{{asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css'))}}">
@endsection
@php
  $route_prefix = "";
  if ($user->is_admin) {
    $route_prefix = "admin.";
  }
  if ($user->is_semi_admin) {
    $route_prefix = "staff.";
  }
@endphp
@section('content')
<form action="{{ route($route_prefix.'cars.category')}}" method="post">
  @csrf
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Browse Car Tuning Specs</h4>
      </div>
      <div class="card-body">
        <div class="row mb-2">
          <div class="col-xl-3 col-md-6 col-12">
            <label class="form-label" for="make">Make</label>
            <select class="form-select" id="make" name="make">
              <option value="">--Choose a Make--</option>
                @foreach($brands as $b)
                  <option value="{{ $b }}">{{ $b }}</option>
                @endforeach
            </select>
          </div>
          <div class="col-xl-3 col-md-6 col-12">
            <label class="form-label" for="model">Model</label>
            <select class="form-select" id="model" name="model">
              <option value="">--Choose a Model--</option>
            </select>
          </div>
          <div class="col-xl-3 col-md-6 col-12">
            <label class="form-label" for="generation">Generation</label>
            <select class="form-select" id="generation" name="generation">
              <option value="">--Choose a Generation--</option>
            </select>
          </div>
          <div class="col-xl-3 col-md-6 col-12">
            <label class="form-label" for="engine">Engine</label>
            <select class="form-select" id="engine" name="engine">
              <option value="">--Choose a Engine--</option>
            </select>
          </div>
        </div>
        <div class="col-12" style="display: flex; justify-content: center">
          <button type="submit" class="btn btn-primary me-1" href="{{ route('cars.category') }}" id="btn-find">Find My Car</button>
        </div>
      </div>
    </div>
  </div>
</div>
</form>
@endsection
@section('vendor-script')
  <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/extensions/polyfill.min.js')) }}"></script>
@endsection
@section('page-script')
<script>
  $("#make").change(function () {
    updateNextOption('make', 'model');
  });
  $('#model').change(function() {
    updateNextOption('model', 'generation');
  });
  $('#generation').change(function() {
    updateNextOption('generation', 'engine');
  });
  $('#engine').change(function() {
    // updateButtonLink();
  });
  function updateNextOption(fromKey, toKey)  {
    $("#make").prop('disabled', 'disabled');
    $("#model").prop('disabled', 'disabled');
    $("#generation").prop('disabled', 'disabled');
    $("#engine").prop('disabled', 'disabled');

    if (fromKey === 'make') {
      $('#model').html(`<option value="">--Choose a ${capitalizeFirstLetter(toKey)}--</option>`);
      $('#generation').html(`<option value="">--Choose a ${capitalizeFirstLetter(toKey)}--</option>`);
      $('#engine').html(`<option value="">--Choose a ${capitalizeFirstLetter(toKey)}--</option>`);
    } else if (fromKey === 'model') {
      $('#generation').html(`<option value="">--Choose a ${capitalizeFirstLetter(toKey)}--</option>`);
      $('#engine').html(`<option value="">--Choose a ${capitalizeFirstLetter(toKey)}--</option>`);
    } else if (fromKey === 'generation') {
      $('#engine').html(`<option value="">--Choose a ${capitalizeFirstLetter(toKey)}--</option>`);
    }

    if ($(`#${fromKey}`).val() !== '') {
      $.ajax({
        type: 'POST',
        url: "{{ route('api.car.query') }}",
        data: {
          make: $('#make').val(),
          model: $('#model').val(),
          generation: $('#generation').val(),
          engine: $('#engine').val(),
        },
        success: function(result) {
          console.log(result);
          $(`#${toKey}`).html(`<option value="">--Choose a ${capitalizeFirstLetter(toKey)}--</option>`)
          for(const item of result){
            if (toKey === 'engine') {
              $(`#${toKey}`).append(`<option value='${item.id}'>${item.engine_type + ' ' + item.std_bhp}</option>`)
            } else {
              $(`#${toKey}`).append(`<option value='${item}'>${item}</option>`)
            }
          }
          $("#make").prop('disabled', false);
          $("#model").prop('disabled', false);
          $("#generation").prop('disabled', false);
          $("#engine").prop('disabled', false);
          $(`#${toKey}`).trigger('change');
        }
      })
    } else {
      $("#make").prop('disabled', false);
      $("#model").prop('disabled', false);
      $("#generation").prop('disabled', false);
      $("#engine").prop('disabled', false);
    }
    // updateButtonLink();
  }
//   function updateButtonLink() {
//     var url = `{{ route('cars.category') }}`
//     if ($('#make').val()) {
//       url += `/?make=${$('#make').val()}`;
//     }
//     if ($('#model').val()) {
//       url += `&model=${$('#model').val()}`;
//     }
//     if ($('#generation').val()) {
//       url += `&generation=${$('#generation').val()}`;
//     }
//     if ($('#engine').val()) {
//       url += `&engine=${$('#engine').val()}`;
//     }
//     console.log(url);
//     $('#btn-find').attr('href', url);
//   }
  function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }
</script>
@endsection
