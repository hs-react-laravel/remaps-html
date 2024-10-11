
@extends('layouts/contentLayoutMaster')

@section('title', 'Create')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')
@php
  $route_prefix = "";
  if ($user->is_semi_admin) {
    $route_prefix = "staff.";
  }
@endphp
<section id="basic-input">
  <form id="storeForm" action="{{ route($route_prefix.'tuning-types.group.store') }}" method="post">
    @csrf
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Add a new tuning type group</h4>
          </div>
          <div class="card-body">
            <div class="row mb-1">
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="name">Group Name</label>
                <input type="text" class="form-control" id="name" name="name" />
              </div>
            </div>
            <div class="row mb-1">
              <div class="col-xl-3 col-md-6 col-12">
                <label class="form-label" for="excludedTypes">Tuning Types</label>
                <select class="form-select" id="excludedTypes" name="excludedTypes[]" multiple="multiple" style="height: 250px">
                  @foreach ($types as $t)
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
                </select>
              </div>
              <div class="col-xl-3 col-md-6 col-12 ms-2">
                @foreach ($types as $t)
                  <div class="credits-container credits-container-{{ $t->id }}" style="display: none">
                    <div>
                      <label class="form-label">Tuning Type Credits</label>
                      <input type="number"
                        class="form-control"
                        id="credits_{{ $t->id }}"
                        name="type_credits[{{ $t->id }}][for_credit]"
                        value="{{ $t->credits }}" />
                    </div>
                    <hr/>
                    <label class="form-label">Options</label>
                    <div class="options-wrapper-{{ $t->id }}">
                    @foreach ($t->tuningTypeOptions as $to)
                    <div class="option-credit-container">
                      <label class="form-label">{{ $to->label }}</label>
                      <div class="input-group">
                        <input type="number"
                          class="form-control"
                          name="option_credits[{{ $t->id }}][{{ $to->id }}][for_credit]"
                          value="{{ $to->credits }}" />
                        <button
                          type="button"
                          class="btn btn-icon btn-danger remove-option"
                          data-type="{{ $t->id }}"
                          data-option="{{ $to->id }}"
                          data-label="{{ $to->label }}"
                          data-credit="{{ $to->credits }}">
                            <i data-feather="trash-2"></i>
                        </button>
                      </div>
                    </div>
                    @endforeach
                    </div>
                    <hr />
                    <div>
                      <label class="form-label">Add Option</label>
                      <div class="input-group">
                        <select id="excludedOptions_{{ $t->id }}" class="form-select add-option-select"></select>
                        <button type="button" class="btn btn-icon btn-success add-option"><i data-feather="plus"></i></button>
                      </div>
                    </div>
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

  <div class="option-credit-container" id="clone_obj" style="display: none">
    <label class="form-label option-label"></label>
    <div class="input-group">
      <input type="number"
        class="form-control option-credit"
        name=""
        value="" />
      <button
        type="button"
        class="btn btn-icon btn-danger remove-option"
        data-type=""
        data-option=""
        data-label=""
        data-credit="">
          <i data-feather="trash-2"></i>
      </button>
    </div>
  </div>
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
    $('body').on('click', '.remove-option', function() {
        var type = $(this).data('type');
        var option = $(this).data('option');
        var credit = $(this).data('credit');
        var label = $(this).data('label');
        $(this).closest('.option-credit-container').remove();
        $('#excludedOptions_' + type).append($('<option>', {
            value: option,
            text : label,
            data: {
                type: type,
                option: option,
                credit: credit,
                label: label
            }
        }));
    })
    $('body').on('click', '.add-option', function() {
        var selectControl = $(this).closest('.input-group').children('.add-option-select');
        var selectedOptionKey = Number($(selectControl).val());
        if (!selectedOptionKey) return;
        var info = {
            type: $(selectControl).find(':selected').data('type'),
            option: $(selectControl).find(':selected').data('option'),
            label: $(selectControl).find(':selected').data('label'),
            credit: $(selectControl).find(':selected').data('credit')
        };
        var newItem = $('#clone_obj').clone();
        newItem.find('.option-label').html(info.label);
        newItem.find('.option-credit')
            .val(info.credit)
            .attr('name', `option_credits[${info.type}][${info.option}][for_credit]`);
        newItem.find('.remove-option')
            .data('type', info.type)
            .data('option', info.option)
            .data('credit', info.credit)
            .data('label', info.label);
        newItem.css('display', 'block');
        $(`.options-wrapper-${info.type}`).append(newItem);
        $(`#excludedOptions_${info.type} option:selected`).each(function() {
            $(this).remove();
        });
    });
</script>
@endsection
