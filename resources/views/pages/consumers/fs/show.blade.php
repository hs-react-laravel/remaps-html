
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
            <h4 class="card-title">View File Service</h4>
          </div>
          <div class="table-responsive">
            <table class="table">
              <tr><th>Make</th><td>{{ $entry->make }}</td></tr>
              <tr><th>Model</th><td>{{ $entry->model }}</td></tr>
              <tr><th>Generation</th><td>{{ $entry->generation }}</td></tr>
              <tr><th>Engine</th><td>{{ $entry->engine }}</td></tr>
              <tr><th>ECU</th><td>{{ $entry->ecu }}</td></tr>
              <tr><th>Engine HP</th><td>{{ $entry->engine_hp }}</td></tr>
              <tr><th>Year of Manufacture</th><td>{{ $entry->year }}</td></tr>
              <tr><th>Gearbox</th><td>{{ $entry->gearbox }}</td></tr>
              <tr><th>Fuel Type</th><td>{{ $entry->fuel_type }}</td></tr>
              <tr><th>Reading Tool</th><td>{{ $entry->reading_tool }}</td></tr>
              <tr><th>License plate</th><td>{{ $entry->license_plate }}</td></tr>
              <tr><th>Miles / KM</th><td>{{ $entry->vin }}</td></tr>
              <tr><th width="30%">Note to engineer</th><td style="overflow-wrap: anywhere">{{ $entry->note_to_engineer }}</td></tr>
            </table>
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
                @if((($entry->status == 'Completed') || ($entry->status == 'Waiting')) && ($entry->modified_file != ""))
                  <tr>
                      <th>Modified file</th>
                      <td>
                        <a href="{{ route('fs.download.modified', ['id' => $entry->id]) }}">download</a>
                        @if($entry->status == 'Waiting')
                          &nbsp;&nbsp;<a href="{{ route('fs.delete.modified', ['id' => $entry->id]) }}">delete</a>
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
