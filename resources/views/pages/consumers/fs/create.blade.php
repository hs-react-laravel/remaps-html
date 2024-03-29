
@extends('layouts/contentLayoutMaster')

@section('title', 'Create a File Service')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')

<section id="basic-input">
  <form action="{{ route('fs.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
    <div class="row">
      <div class="col-md-12">
        <div class="card" id="dropContainer">
          <div class="card-header">
            <h4 class="card-title">Add a new file service</h4>
          </div>
          <div class="card-body">
            <div class="row mb-1">
              <div class="col-xl-3 col-md-3 col-12">
                <label class="form-label" for="make">Make</label>
                <input
                  type="text"
                  class="form-control"
                  id="make"
                  name="make"
                  required
                  value="{{ old('make') ?? null }}"/>
              </div>
              <div class="col-xl-3 col-md-3 col-12">
                <label class="form-label" for="model">Model</label>
                <input
                  type="text"
                  class="form-control"
                  id="model"
                  name="model"
                  required
                  value="{{ old('model') ?? null }}" />
              </div>
              <div class="col-xl-3 col-md-3 col-12">
                <label class="form-label" for="generation">Generation</label>
                <input
                  type="text"
                  class="form-control"
                  id="generation"
                  name="generation"
                  required
                  value="{{ old('generation') ?? null }}" />
              </div>
            </div>

            <div class="row mb-1">
              <div class="col-xl-3 col-md-3 col-12">
                <label class="form-label" for="engine">Engine</label>
                <input
                  type="text"
                  class="form-control"
                  id="engine"
                  name="engine"
                  required
                  value="{{ old('engine') ?? null }}" />
              </div>
              <div class="col-xl-3 col-md-3 col-12">
                <label class="form-label" for="ecu">ECU</label>
                <input
                  type="text"
                  class="form-control"
                  id="ecu"
                  name="ecu"
                  required
                  value="{{ old('ecu') ?? null }}" />
              </div>
              <div class="col-xl-3 col-md-3 col-12">
                <label class="form-label" for="engine_hp">Engine HP</label>
                <input
                  type="number"
                  class="form-control"
                  id="engine_hp"
                  name="engine_hp"
                  value="{{ old('engine_hp') ?? null }}" />
              </div>
            </div>

            <div class="row mb-1">
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="year">Year of Manufacture</label>
                <select class="select2 form-select" id="year" name="year" required>
                  <option value="">Choose</option>
                  @for ($i = 1990; $i <= date('Y'); $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                  @endfor
                </select>
              </div>
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="gearbox">Gearbox</label>
                <select class="select2 form-select" id="gearbox" name="gearbox" required>
                  <option value="">Choose</option>
                  @foreach (config('constants.file_service_gearbox') as $key => $title)
                    <option value="{{ $key }}">{{ $title }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="row mb-1">
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="fuel_type">Fuel Type</label>
                <select class="select2 form-select" id="fuel_type" name="fuel_type" required>
                  <option value="">Choose</option>
                  @foreach (config('constants.file_service_fuel_type') as $key => $title)
                    <option value="{{ $key }}">{{ $title }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="reading_tool">Reading Tool</label>
                <select class="select2 form-select" id="reading_tool" name="reading_tool" required>
                  <option value="">Choose</option>
                  @foreach (config('constants.file_service_reading_tool') as $key => $title)
                    <option value="{{ $key }}">{{ $title }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="row mb-1">
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="license_plate">License plate</label>
                <input
                  type="text"
                  class="form-control"
                  id="license_plate"
                  name="license_plate"
                  required
                  value="{{ old('license_plate') ?? null }}" />
              </div>
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="vin">Miles / KM</label>
                <input
                  type="text"
                  class="form-control"
                  id="vin"
                  name="vin"
                  value="{{ old('vin') ?? null }}" />
              </div>
            </div>

            <div class="row mb-1">
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="note_to_engineer">Note to engineer</label>
                <textarea
                  class="form-control"
                  id="note_to_engineer"
                  rows="5"
                  name="note_to_engineer"
                >{{ old('note_to_engineer') ?? '' }}</textarea>
              </div>
              <div class="col-xl-4 col-md-6 col-12" class="tuning-type-div">
                <div id="clone" style="display: none" class="mt-1">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input tuning-option-check" type="checkbox" name="tuning_type_options[]" value="1" data-price="0" />
                    <label class="form-check-label tuning-option-label">A</label>
                  </div>
                </div>
                <label class="form-label" for="tuning_type_id">Tuning Type</label>
                <select class="form-select" id="tuning_type_id" name="tuning_type_id" required>
                  <option value="" data-price="0">Select Tuning Type</option>
                  @foreach ($tuningTypes as $opt)
                    <option value="{{ $opt->id }}" data-price="{{ $opt->credits }}">{{ $opt->label }}</option>
                  @endforeach
                </select>
                <div class="mt-1">
                  <label class="form-label">Tuning Type Options</label>
                  <div class="tuning-options-wrapper">
                  </div>
                </div>
              </div>
            </div>

            <div class="row mb-1">
              <div class="col-12 mb-1">
                <div style="margin-bottom: 2px">
                  <label for="orginal_file" class="form-label">Original file</label>
                  <div class="input-group" onclick="onUpload()">
                    <span class="input-group-text">Choose File</span>
                    <input
                      type="text"
                      class="form-control"
                      id="file_name"
                      name="file_name"
                      readonly />
                    <input
                      type="hidden"
                      class="form-control"
                      id="orginal_file"
                      name="orginal_file"
                      readonly />
                    <input
                      type="hidden"
                      class="form-control"
                      id="remain_orginal_file"
                      name="remain_orginal_file"
                      readonly />
                  </div>
                </div>
                <div class="progress progress-bar-{{ substr($styling['navbarColor'], 3) }}" style="display: none">
                  <div
                    class="progress-bar progress-bar-striped progress-bar-animated"
                    role="progressbar"
                    aria-valuenow="0"
                    aria-valuemin="0"
                    aria-valuemax="100"
                  ></div>
                </div>
                <span class="text-danger">Drag and drop file here</span>
              </div>
            </div>
            @if($company->is_tc)
            <div class="row mb-1">
              <div class="col-12 mb-1">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" id="is_tc" name="is_tc" required/>
                  <label class="form-check-label" for="is_tc">I agree to the <a target="_blank" href="{{ asset('storage/uploads/tc/'.$company->tc_pdf) }}">terms and conditions</a></label>
                </div>
              </div>
            </div>
            @endif
            <button type="submit" class="btn btn-primary me-1" id="btnSubmit">Submit</button>
            <button type="button" class="btn btn-flat-secondary me-1" onclick="history.back(-1)">Cancel</button>

          </div>
        </div>
      </div>
    </div>

  </form>
  {{ Form::open(array('id' => 'uploadForm', 'route' => 'fileservices.api.upload', 'method' => 'POST', 'enctype' => 'multipart/form-data')) }}
    <input type="file" name="file" id="hidden_upload" style="display: none" />
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
    var orgPrice = 0;
    var totalPrice = 0;
    var checkItem = [];
    var creditPrice = {{ $creditPrice }};
    var currencyCode = "{{ config('constants.currency_signs')[$company->paypal_currency_code] }}";
    $('#tuning_type_id').on('change', function(e){
      var id = $(this).val();
      var price = e.target.options[e.target.selectedIndex].dataset.price;
      orgPrice = Number(price);
      totalPrice = Number(price);
      $.ajax({
        url: `/api/tuning-type-options/${id}`,
        type: 'GET',
        data: {
          _token: '{{ csrf_token() }}',
        },
        dataType: 'JSON',
        success: function (data) {
          $('.tuning-options-wrapper').html('');
          checkItem = [];
          data.forEach((item) => {
            var newItem = $('#clone').clone();
            newItem.show();
            $(newItem).find('.tuning-option-label').html(`${item.label} (${item.credits} credits)`);
            $(newItem).find('.tuning-option-label').data('id', item.id);
            $(newItem).find('.tuning-option-check').val(item.id);
            $(newItem).find('.tuning-option-check').data('price', item.credits.replace(",", ""));
            $('.tuning-options-wrapper').append(newItem);
            checkItem.push($(newItem).find('.tuning-option-check'));
          })
          $('#btnSubmit').html(`Submit (${totalPrice.toFixed(2)} credits : ${currencyCode} ${(creditPrice * totalPrice).toFixed(2)})`);
        }
      });
    });
    $('body').on('click', 'label.tuning-option-label', function(){
      var parent = $(this).parent();
      $(parent).find('.tuning-option-check').trigger('click');
    })
    $('body').on('change', '.tuning-options-wrapper .tuning-option-check', function(){
      totalPrice = orgPrice;
      checkItem.forEach(ci => {
        if($(ci).prop('checked')) {
          totalPrice += Number($(ci).data('price'));
        }
      })
      $('#btnSubmit').html(`Submit (${totalPrice.toFixed(2)} credits : ${currencyCode} ${(creditPrice * totalPrice).toFixed(2)})`);
    })
  function onUpload() {
    $('#hidden_upload').trigger('click');
  }
  function submitFile() {
    const [file] = hidden_upload.files
    if (file) {
      $('#file_name').val(file.name)
      $("#uploadForm").submit();
    }
  }
  dropContainer.ondragover = dropContainer.ondragenter = function(evt) {
    evt.preventDefault()
  }
  dropContainer.ondrop = function(evt) {
    const dT = new DataTransfer();
    dT.items.add(evt.dataTransfer.files[0]);
    hidden_upload.files = dT.files
    evt.preventDefault()
    submitFile()
  }
  hidden_upload.onchange = evt => {
    submitFile()
  }
  $("#uploadForm").on('submit', function(e){
    e.preventDefault();
    $.ajax({
      xhr: function() {
        var xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener("progress", function(evt) {
          if (evt.lengthComputable) {
            var percentComplete = Math.round((evt.loaded / evt.total) * 100);
            $(".progress-bar").width(percentComplete + '%');
            $(".progress-bar").html(percentComplete+'%');
          }
        }, false);
        return xhr;
      },
      type: 'POST',
      url: "{{ route('fs.api.upload') }}",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData:false,
      beforeSend: function(){
        $(".progress-bar").width('0%');
        $(".progress").show();
      },
      error:function(){

      },
      success: function(resp){
        if(resp.status){
          $('#uploadForm')[0].reset();
          $('#orginal_file').val(resp.file);
          $('#remain_orginal_file').val(resp.remain);
        }else{
        }
      }
    });
  })
  </script>
@endsection
