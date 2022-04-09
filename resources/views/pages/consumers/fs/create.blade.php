
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
        <div class="card">
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
                  @for ($i = 1990; $i <= date('Y'); $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                  @endfor
                </select>
              </div>
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="gearbox">Gearbox</label>
                <select class="select2 form-select" id="gearbox" name="gearbox">
                  @foreach (config('constants.file_service_gearbox') as $key => $title)
                    <option value="{{ $key }}">{{ $title }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="row mb-1">
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="fuel_type">Fuel Type</label>
                <select class="select2 form-select" id="fuel_type" name="fuel_type">
                  @foreach (config('constants.file_service_fuel_type') as $key => $title)
                    <option value="{{ $key }}">{{ $title }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="reading_tool">Reading Tool</label>
                <select class="select2 form-select" id="reading_tool" name="reading_tool">
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
                    <input class="form-check-input tuning-option-check" type="checkbox" name="tuning_type_options[]" value="1" />
                    <label class="form-check-label tuning-option-label">A</label>
                  </div>
                </div>
                <label class="form-label" for="tuning_type_id">Tuning Type</label>
                <select class="form-select" id="tuning_type_id" name="tuning_type_id" required>
                  <option value="">Select Tuning Type</option>
                  @foreach ($tuningTypes as $key => $title)
                    <option value="{{ $key }}">{{ $title }}</option>
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
                  <label for="orginal_file" class="form-label">Modified file</label>
                  <div class="input-group" onclick="onUpload()" id="dropContainer">
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
              </div>
            </div>

            <button type="submit" class="btn btn-primary me-1">Submit</button>
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
      var parent = $(this).parent();
      $(parent).find('.tuning-option-check').trigger('click');
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
