
@extends('layouts/contentLayoutMaster')

@section('title', 'Edit File Service')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')

<section id="basic-input">
  <form action="{{ route('fs.update', ['f' => $entry->id]) }}" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="PUT">
    @csrf
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Edit the file service</h4>
          </div>
          <div class="card-body">
            <div class="row mb-1">
              <div class="col-xl-6 col-md-6 col-12">
                <label class="form-label" for="make">Make</label>
                <input type="text" class="form-control" id="make" name="make" value="{{ $entry->make }}" />
              </div>
              <div class="col-xl-6 col-md-6 col-12">
                <label class="form-label" for="model">Model</label>
                <input type="text" class="form-control" id="model" name="model" value="{{ $entry->model }}" />
              </div>
              <div class="col-xl-6 col-md-6 col-12">
                <label class="form-label" for="generation">Generation</label>
                <input type="text" class="form-control" id="generation" name="generation" value="{{ $entry->generation }}" />
              </div>
              <div class="col-xl-6 col-md-6 col-12">
                <label class="form-label" for="engine">Engine</label>
                <input type="text" class="form-control" id="engine" name="engine" value="{{ $entry->engine }}" />
              </div>
              <div class="col-xl-6 col-md-6 col-12">
                <label class="form-label" for="ecu">ECU</label>
                <input type="text" class="form-control" id="ecu" name="ecu" value="{{ $entry->ecu }}" />
              </div>
              <div class="col-xl-6 col-md-6 col-12">
                <label class="form-label" for="engine_hp">Engine HP</label>
                <input type="number" class="form-control" id="engine_hp" name="engine_hp" value="{{ $entry->engine_hp }}" />
              </div>
            </div>

            <div class="row mb-1">
              <div class="col-xl-6 col-md-6 col-12">
                <label class="form-label" for="year">Year of Manufacture</label>
                <select class="select2 form-select" id="year" name="year">
                  @for ($i = 1990; $i <= date('Y'); $i++)
                    <option value="{{ $i }}" @if($entry->year == $i) selected @endif>{{ $i }}</option>
                  @endfor
                </select>
              </div>
              <div class="col-xl-6 col-md-6 col-12">
                <label class="form-label" for="gearbox">Gearbox</label>
                <select class="select2 form-select" id="gearbox" name="gearbox">
                  @foreach (config('constants.file_service_gearbox') as $key => $title)
                    <option value="{{ $key }}" @if($entry->year == $key) selected @endif>{{ $title }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="row mb-1">
              <div class="col-xl-6 col-md-6 col-12">
                <label class="form-label" for="fuel_type">Fuel Type</label>
                <select class="select2 form-select" id="fuel_type" name="fuel_type">
                  @foreach (config('constants.file_service_fuel_type') as $key => $title)
                    <option value="{{ $key }}" @if($entry->year == $key) selected @endif>{{ $title }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-xl-6 col-md-6 col-12">
                <label class="form-label" for="reading_tool">Reading Tool</label>
                <select class="select2 form-select" id="reading_tool" name="reading_tool">
                  @foreach (config('constants.file_service_reading_tool') as $key => $title)
                    <option value="{{ $key }}" @if($entry->year == $key) selected @endif>{{ $title }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="row mb-1">
              <div class="col-xl-6 col-md-6 col-12">
                <label class="form-label" for="license_plate">License plate</label>
                <input type="text" class="form-control" id="license_plate" name="license_plate" value="{{ $entry->license_plate }}" />
              </div>
              <div class="col-xl-6 col-md-6 col-12">
                <label class="form-label" for="vin">Miles / KM</label>
                <input type="text" class="form-control" id="vin" name="vin" value="{{ $entry->vin }}" />
              </div>
            </div>

            <div class="row mb-1">
              <div class="col-xl-12 col-md-12 col-12">
                <label class="form-label" for="note_to_engineer">Note to engineer</label>
                <textarea
                  class="form-control"
                  id="note_to_engineer"
                  rows="5"
                  name="note_to_engineer"
                > {{ $entry->note_to_engineer }}</textarea>
              </div>
            </div>

            <button type="submit" class="btn btn-primary me-1">Submit</button>
            <button type="button" class="btn btn-flat-secondary me-1" onclick="history.back(-1)">Cancel</button>

          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">File service information</h4>
          </div>
          <div class="table-responsive">
            <table class="table">
              <tbody>
                <tr>
                  <th>No.</th>
                  <td>{{ $entry->displayable_id }}</td>
                </tr>
                <tr>
                  <th>Status</th>
                  <td>{{ $entry->status }}</td>
                </tr>
                <tr>
                  <th>Date submitted</th>
                  <td>{{ $entry->created_at }}</td>
                </tr>
                <tr>
                  <th>Tuning type</th>
                  <td>{{ $entry->tuningType->label }}</td>
                </tr>
                <tr>
                    <th>Tuning options</th>
                    <td>{{ $entry->tuningTypeOptions()->pluck('label')->implode(',') }}</td>
                </tr>
                <tr>
                  <th>Credits</th>
                    @php
                      $tuningTypeCredits = $entry->tuningType->credits;
                      $tuningTypeOptionsCredits = $entry->tuningTypeOptions()->sum('credits');
                      $credits = ($tuningTypeCredits+$tuningTypeOptionsCredits);
                    @endphp
                    <td>{{ number_format($credits, 2) }}</td>
                </tr>
                <tr>
                    <th>Original file</th>
                    <td><a href="{{ route('fs.download.original', ['id' => $entry->id]) }}">download</a></td>
                </tr>
                @if(($entry->status == 'Completed') && ($entry->modified_file != ""))
                  <tr>
                      <th>Modified file</th>
                      <td>
                        <a href="{{ url('file-service/'.$entry->id.'/download-modified') }}">download</a>
                        @if($entry->status == 'Waiting' && $user->is_admin)
                          &nbsp;&nbsp;<a href="{{ route('fs.download.modified', ['id' => $entry->id]) }}">delete</a>
                        @endif
                      </td>
                  </tr>
                @endif
                <tr>
                  <th width="30%">Notes By Engineer</th>
                  <td style="overflow-wrap: anywhere">{{ $entry->notes_by_engineer }}</td>
                </tr>
              </tbody>
            </table>
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
  <script>
    $('#tuning_type_id').on('change', function(){
      var id = $(this).val();
      $.ajax({
        url: `/api/tuning-type-options/${id}`,
        type: 'GET',
        data: {
          _token: '{{ csrf_token() }}',
        },
        dataType: 'JSON',
        success: function (data) {
          $('.tuning-options-wrapper').html('');
          console.log(data);
          data.forEach((item) => {
            var newItem = $('#clone').clone();
            newItem.show();
            $(newItem).find('.tuning-option-label').html(`${item.label} (${item.credits} credits)`);
            $(newItem).find('.tuning-option-label').data('id', item.id);
            $(newItem).find('.tuning-option-check').val(item.id);
            $('.tuning-options-wrapper').append(newItem);
          })
        }
      });
    });
    $('body').on('click', 'label.tuning-option-label', function(){
      console.log('aaa');
      var parent = $(this).parent();
      $(parent).find('.tuning-option-check').trigger('click');
    })
  </script>
@endsection
