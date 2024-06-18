
@extends('layouts/contentLayoutMaster')

@section('title', 'Edit')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')

<section id="basic-input">
  <form id="storeForm" action="{{ route('tuning-types.group.update', ['id' => $group->id]) }}" method="post">
    @csrf
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Edit tuning type group</h4>
          </div>
          <div class="card-body">
            <div class="row mb-1">
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="name">Group Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $group->name }}" />
              </div>
            </div>
            <div class="row mb-1">
              <div class="col-xl-3 col-md-6 col-12">
                <label class="form-label" for="excludedTypes">Tuning Types</label>
                <select class="form-select" id="excludedTypes" name="excludedTypes[]" multiple="multiple" style="height: 250px">
                  @foreach ($exTypes as $t)
                    <option value="{{ $t->id }}">{{ $t->label }}</option>
                  @endforeach
                </select>
              </div>
              <div class="d-flex align-items-center justify-content-center" style="width: 100px; height: 280px">
                <div>
                  <button type="button" class="btn btn-primary" onclick="onInclude()">>></button>
                  <button type="button" class="btn btn-primary mt-1" onclick="onExclude()"><<</button>
                </div>
              </div>
              <div class="col-xl-3 col-md-6 col-12">
                <label class="form-label" for="includedTypes">Included Tuning Types</label>
                <select class="form-select" id="includedTypes" multiple="multiple" name="includedTypes[]" style="height: 250px">
                  @foreach ($inTypes as $t)
                    <option value="{{ $t->id }}">{{ $t->label }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-xl-3 col-md-6 col-12 ms-2">
                @foreach ($types as $t)
                  <div class="credits-container credits-container-{{ $t->id }}" style="display: none">
                    <div>
                      @php
                          $mType = $group->getOneType($t->id);
                      @endphp
                      <label class="form-label" for="credits">Tuning Type Credits @if($mType && $mType->pivot->for_credit != $t->credits)<span style="color: red">*</span>@endif</label>
                      <input type="number"
                        class="form-control"
                        id="credits_{{ $t->id }}"
                        name="type_credits[{{ $t->id }}][for_credit]"
                        value="{{ $mType ? $mType->pivot->for_credit : $t->credits }}" />
                    </div>
                    <hr/>
                    <label class="form-label" for="credits">Options</label>
                    @foreach ($t->tuningTypeOptions as $to)
                    <div>
                      @php
                          $mOption = $group->getOneOption($to->id);
                      @endphp
                      <label class="form-label" for="credits">{{ $to->label }}@if($mOption && $mOption->pivot->for_credit != $to->credits) <span style="color: red">*</span>@endif</label>
                      <input type="number"
                        class="form-control"
                        id="credits_{{ $t->id }}_{{ $to->id }}"
                        name="option_credits[{{ $t->id }}][{{ $to->id }}][for_credit]"
                        value="{{ $mOption ? $mOption->pivot->for_credit : $to->credits }}" />
                    </div>
                    @endforeach
                  </div>
                @endforeach
              </div>
            </div>
            <button type="button" class="btn btn-primary me-1" onclick="onSubmit()">Submit</button>
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
  <script>
      function onInclude() {
        var selected = [];
        $( "#excludedTypes option:selected" ).each(function() {
            selected.push({ value: $(this).val(), text: $(this).text() });
            $(this).remove();
        });
        $.each(selected, function(i, item) {
            $('#includedTypes').append($('<option>', {
                value: item.value,
                text : item.text
            }));
        })
        $('.credits-container').hide();
      }
      function onExclude() {
        var selected = [];
        $( "#includedTypes option:selected" ).each(function() {
            selected.push({ value: $(this).val(), text: $(this).text() });
            $(this).remove();
        });
        $.each(selected, function(i, item) {
            $('#excludedTypes').append($('<option>', {
                value: item.value,
                text : item.text
            }));
        })
        $('.credits-container').hide();
      }
      function onSubmit() {
          $('#excludedTypes option').prop('selected', true);
          $('#includedTypes option').prop('selected', true);
          $('#storeForm').submit();
      }
      $('#includedTypes').on('change', function() {
          if (this.value) {
              $('.credits-container').hide();
              $('.credits-container-' + this.value).show();
          } else {
            $('.credits-container').hide();
          }
      });
  </script>
@endsection
