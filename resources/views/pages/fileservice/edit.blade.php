@extends('layouts/contentLayoutMaster')

@section('title', 'Edit File Service')

@section('content')
<!-- Basic Vertical form layout section start -->
<section id="basic-vertical-layouts">
  <div class="row">
    <div class="col-md-6 col-12">
      <div class="card" id="dropContainer">
        <div class="card-header">
          <h4 class="card-title">Process the file service</h4>
        </div>
        <div class="card-body">
          {{ Form::model($fileService, array('route' => array('fileservices.update', $fileService->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data')) }}
            <div class="row">
              <div class="col-12">
                <div class="mb-1">
                  <label class="form-label" for="status">Status</label>
                  <select class="form-select" id="status" name="status">
                    @foreach (config('constants.file_service_staus') as $key => $value)
                      <option value="{{$key}}" @if($fileService->status == $value) selected @endif>{{$value}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-12 mb-1">
                <div style="margin-bottom: 2px">
                  <label for="modified_file" class="form-label">Modified file</label>
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
                      id="modified_file"
                      name="modified_file"
                      readonly />
                    <input
                      type="hidden"
                      class="form-control"
                      id="remain_modified_file"
                      name="remain_modified_file"
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
              <div class="col-12">
                <div class="mb-1">
                  <label class="form-label" for="notes_by_engineer">Notes by engineer</label>
                  <textarea
                    class="form-control"
                    id="notes_by_engineer"
                    rows="3"
                    name="notes_by_engineer"
                  >{{ $fileService->notes_by_engineer }}</textarea>
                </div>
              </div>
              @if (!$user->is_staff)
              <div class="col-12">
                <div class="mb-1">
                  <label class="form-label" for="assign">{{__('locale.tb_header_Assign')}}</label>
                  <select class="form-select" id="assign" name="assign">
                    <option value=""></option>
                    @foreach ($company->staffs as $staff)
                      <option value="{{ $staff->id }}" @if($fileService->assign_id == $staff->id) selected @endif>{{ $staff->fullname }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-12 mb-1" id="is_delay_wrapper" style="display: none">
                <div class="form-check form-check-inline">
                  <input type="hidden" name="is_delay" value="0" />
                  <input class="form-check-input" type="checkbox" id="is_delay" name="is_delay" value="1"/>
                  <label class="form-check-label" for="is_delay">Delay Complete</label>
                </div>
              </div>
              <div class="col-12 mb-1" id="delay_time_wrapper" style="display: none">
                <label class="form-label" for="delay_time">Delay Time</label>
                <select class="form-select" id="delay_time" name="delay_time">
                  @for ($i = 1; $i <= 6; $i++)
                    <option value="{{$i * 10}}">{{$i * 10}} min</option>
                  @endfor
                </select>
              </div>
              @endif
            </div>
            <button id="fs-save" type="submit" class="btn btn-primary me-1">Save</button>
            <button type="button" class="btn btn-flat-secondary me-1" onclick="history.back(-1)">Cancel</button>
          {{ Form::close() }}
          {{ Form::open(array('id' => 'uploadForm', 'route' => 'fileservices.api.upload', 'method' => 'POST', 'enctype' => 'multipart/form-data')) }}
            <input type="file" name="file" id="hidden_upload" style="display: none" />
          {{ Form::close() }}
        </div>
      </div>
      @include('blocks.customer_info')
    </div>
    <div class="col-md-6 col-12">
      @include('blocks.fileservice_info')
      @include('blocks.car_info')
    </div>
  </div>
</section>
<!-- Basic Vertical form layout section end -->
@endsection

@section('page-script')
<script>
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
  $('#status').change(function(e) {
    if (e.target.value == 'C') {
      $('#is_delay_wrapper').show()
    }
  })
  $('#is_delay').change(function(e) {
    if ($(this).prop('checked')) {
      $('#delay_time_wrapper').show()
    }
  })
  $("#uploadForm").on('submit', function(e){
    e.preventDefault();
    $('#fs-save').prop('disabled', true);
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
      url: "{{ route('fileservices.api.upload') }}",
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
          $('#modified_file').val(resp.file);
          $('#remain_modified_file').val(resp.remain);
        }else{
        }
        $('#fs-save').prop('disabled', false);
      }
    });
  })
</script>
@endsection
